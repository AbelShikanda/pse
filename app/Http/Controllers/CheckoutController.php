<?php

namespace App\Http\Controllers;

use App\Mail\newCheckout;
use App\Models\Cart;
use App\Models\Order_Items;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\PromoCodes;
use App\Models\User;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Exception;

class CheckoutController extends Controller
{
    private $mpesaService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MpesaService $mpesaService)
    {
        $this->middleware('auth');
        $this->mpesaService = $mpesaService;  // Inject the service
    }

    public function postCheckout(Request $request, $id)
    {
        if (Auth::user()->email_verified_at === null) {
            return redirect()->route('profile');
        }

        if (!Session::has('cart')) {
            return redirect()->route('catalog');
        }

        $product = ProductImages::find($id);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $request->validate([
            // 'mpesa_ref' => 'alpha_num|unique:orders,reference|max:10|min:10',
            'mpesa_ref' => '',
            'total' => '',
            'first_name' => '',
            'last_name' => '',
            'landmark' => '',
            'house_no' => '',
            'estate' => '',
            'phone' => '',
            'town' => '',
            // 'mpesa_ref' => 'required|alpha_num|unique:orders,reference|max:10|min:10',
            // 'total' => 'required|numeric|min:1',
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'landmark' => 'nullable|string|max:255',
            // 'house_no' => 'nullable|string|max:255',
            // 'estate' => 'nullable|string|max:255',
            // 'phone' => 'required|digits_between:10,15',
            // 'town' => 'required|string|max:255',
        ]);
        // dd($request->all());

        $order = new Orders();
        $order->tracking_No = serialize($cart);
        $order->price = $request->total;
        // $order->reference = $request->mpesa_ref;
        $order->reference = 'DHJEIOKSJU';
        $order->user_id = Auth::user()->uuid;
        if ($appliedPromo = Session::get('applied_promo')) {
            $promoCode = PromoCodes::where('code', $appliedPromo)->first();
            if ($promoCode) {
                $order->promo_code_id = $promoCode->id;
            }
        }

        DB::beginTransaction();
        try {
            $invalidSizeMessage = 'Please select a valid size. "All Sizes" is not a valid option.';
            // Save order first, once.

            // dd($order);
            Auth::user()->order()->save($order);

            foreach ($cart->items as $item) {
                $orderItemData = null;

                // Check if `id` exists and is valid
                if (isset($item['size'])) {
                    if ($item['size'] == 12) {
                        // If size is invalid, roll back transaction and return the error
                        DB::rollBack();
                        return back()->with(['message' => $invalidSizeMessage]);
                    } else {
                        $orderItemData = [
                            'order_id' => $order->id,
                            'product_id' => $item['product_id'],
                            'color_id' => $request->color,
                            'size_id' => $item['size'],
                            'quantity' => $item['qty'],
                            'price' => $item['price'],
                        ];
                    }
                } else {
                    DB::rollBack();
                    return back()->with(['message' => $invalidSizeMessage]);
                }

                // Insert the order item if data is valid
                if ($orderItemData) {
                    $orderItem = new Order_Items($orderItemData);
                    $orderItem->save();
                }
            }
            // $mpesaResponse = $this->mpesaService->stkPushRequest($request->phone, $request->total);
            $mpesaResponse = $this->mpesaService->stkPushRequest('0728157164', '1');
            if (isset($mpesaResponse['error'])) {
                DB::rollBack();
                dd($mpesaResponse);
                return back()->with(['message' => $mpesaResponse['error']]);
            }

            // Commit the transaction only after all items are processed
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error processing order: ' . $e->getMessage());
            return back()->with(['message' => $invalidSizeMessage]);
        }

        // dd($order_items);

        Session::forget('applied_promo');
        Session::forget('cart');

        $order = Orders::with(['orderItems', 'orderItems.products', 'orderItems.products.ProductImage', 'orderItems.size', 'orderItems.color'])->find($order->id);

        $image = ProductImages::where('products_id', $id)->first();
        $email = User::where('uuid', Auth::user()->uuid)->pluck('email');
        $user = User::where('id', $order->user_id)->first();

        Mail::to($email)->bcc('printshopeld@gmail.com')->send(new newCheckout($order, $image, $user));

        return redirect()->route('home')->with('message', 'Your order has been placed Successfully.');
    }

    public function mpesaCallback(Request $request, MpesaService $mpesaService)
    {
        $mpesaResponse = $request->all();
        $payment = $mpesaService->handleMpesaCallback($mpesaResponse);

        if ($payment) {
            return response()->json(['message' => 'Payment received and recorded.'], 200);
        }

        return response()->json(['message' => 'Payment failed or invalid response.'], 400);
    }
}
