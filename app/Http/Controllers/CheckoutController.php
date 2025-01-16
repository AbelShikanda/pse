<?php

namespace App\Http\Controllers;

use App\Mail\newCheckout;
use App\Models\Cart;
use App\Models\Order_Items;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postCheckout(Request $request, $id)
    {

        try {
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
                'mpesa_ref' => 'alpha_num|unique:orders,reference|max:10|min:10',
                'mpesa_ref' => '',
                'total' => '',
                'first_name' => '',
                'last_name' => '',
                'landmark' => '',
                'house_no' => '',
                'estate' => '',
                'phone' => '',
                'town' => '',
            ]);
            // dd($request->all());

            $order = new Orders();
            $order->tracking_No = serialize($cart);
            $order->price = $request->total;
            $order->reference = $request->mpesa_ref;
            // $order->reference = 'SJ48VKFUQQ';
            $order->user_id = Auth::user()->uuid;

            DB::beginTransaction();

            try {
                Auth::user()->order()->save($order); // Save order first, once.

                foreach ($cart->items as $item) {
                    $orderItemData = null;

                    // Check if `id` exists and is valid
                    if (isset($item['item']['products'][0]['size'][0]['id']) && !isset($item['item']['products'][0]['size'][0]['name']['id'])) {
                        if ($item['item']['products'][0]['size'][0]['id'] == 12) {
                            throw new Exception('Please select a valid size, "All Sizes" is not a valid size.');
                        } else {
                            $orderItemData = [
                                'order_id' => $order->id,
                                'product_id' => $item['item']['products'][0]['id'],
                                'color_id' => $request->color,
                                'size_id' => $item['item']['products'][0]['size'][0]['id'],
                                'quantity' => $item['qty'],
                                'price' => $item['price'],
                            ];
                        }
                    }
                    // Check if `name` exists and is valid
                    elseif (isset($item['item']['products'][0]['size'][0]['name']['id'])) {
                        if ($item['item']['products'][0]['size'][0]['name']['id'] == 12) {
                            throw new Exception('Please select a valid size, "All Sizes" is not a valid size.');
                        } else {
                            $orderItemData = [
                                'order_id' => $order->id,
                                'product_id' => $item['item']['products'][0]['id'],
                                'color_id' => $request->color,
                                'size_id' => $item['item']['products'][0]['size'][0]['name']['id'],
                                'quantity' => $item['qty'],
                                'price' => $item['price'],
                            ];
                        }
                    } else {
                        throw new Exception('Please select a valid size, "All Sizes" is not a valid size.');
                    }

                    // Insert the order item if data is valid
                    if ($orderItemData) {
                        $orderItem = new Order_Items($orderItemData);
                        $orderItem->save();
                    }
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
                return back()->with(['message' => $e->getMessage()]);
            }


            // dd($order_items);

            Session::forget('cart');

            $order = Orders::with([
                'orderItems',
                'orderItems.products',
                'orderItems.products.ProductImage',
                'orderItems.size',
                'orderItems.color',
            ])->find($order->id);

            $image = ProductImages::where('products_id', $id)->first();
            $email = User::where('uuid', Auth::user()->uuid)->pluck('email');
            $user = User::where('id', $order->user_id)->first();

            Mail::to($email)
                ->bcc('printshopeld@gmail.com')
                ->send(new newCheckout($order, $image, $user));

            return redirect()->route('home')->with('message', 'Your order has been placed Successfully.');
            
        } catch (\Exception $e) {
            // Log the error for internal review
            \Log::error('Checkout error: ' . $e->getMessage());

            // Return a user-friendly message
            return back()->with('error', 'An error occurred while processing your request. Please try again later.');
        }
    }
}
