<?php

namespace App\Http\Controllers;

use App\Mail\newCheckout;
use App\Models\Cart;
use App\Models\MpesaPayment;
use App\Models\Order_Items;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\PromoCodes;
use App\Models\User;
use App\Services\MpesaService;
use Carbon\Carbon;
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
        $this->middleware('auth')->except(['mpesaCallback']);
        $this->mpesaService = $mpesaService;
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
            'total' => 'required|numeric|min:1',
            'phone' => ['required', 'regex:/^254\d{9}$/', 'digits:12'],
        ]);

        $order = new Orders();
        $order->tracking_No = serialize($cart);
        $order->price = $request->total;
        $order->reference = Auth::user()->first_name;
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

            Auth::user()->order()->save($order);
            DB::commit();

            foreach ($cart->items as $item) {
                $orderItemData = null;
                // dd($item['size']);

                // Check if `id` exists and is valid
                if (isset($item['size'])) {
                    // dd($item['size']);
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

                if ($orderItemData) {
                    $orderItem = new Order_Items($orderItemData);
                    $orderItem->save();
                }
            }
            $mpesaResponse = $this->mpesaService->stkPushRequest($request->phone, $request->total);
            if (isset($mpesaResponse['error'])) {
                DB::rollBack();
                return back()->with(['message' => $mpesaResponse['error']]);
            }

            $maxAttempts = 10;
            $attempt = 0;

            Log::info("Checking payment status for: {$request->phone}");

            while ($attempt < $maxAttempts) {
                sleep(min(2 * pow(2, $attempt), 30));

                DB::disconnect('mysql');
                DB::reconnect('mysql');

                $paymentConfirmed = MpesaPayment::on('mysql')
                    ->where('phone_number', ltrim($request->phone, '+'))
                    ->where('amount', $request->total)
                    ->where('status', 'Completed')
                    ->latest()
                    ->withoutGlobalScopes()
                    ->exists();

                Log::info("Attempt #$attempt: Checking payment status for {$request->phone}. Found: " . ($paymentConfirmed ? 'Yes' : 'No'));

                if ($paymentConfirmed) {
                    Log::info('Payment confirmed, exiting loop.');
                    $order->complete = 1;
                    $order->save();
                    DB::commit();
                    Log::info('Order marked as complete.');
                    break;
                }

                $attempt++;
            }

            DB::reconnect('mysql');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error processing order: ' . $e->getMessage());
            return back()->with(['message' => $invalidSizeMessage]);
        }

        Session::forget('applied_promo');
        Session::forget('cart');

        $order = Orders::with(['orderItems', 'orderItems.products', 'orderItems.products.ProductImage', 'orderItems.size', 'orderItems.color'])->find($order->id);

        $image = ProductImages::where('products_id', $id)->first();
        $email = User::where('uuid', Auth::user()->uuid)->pluck('email');
        $user = User::where('id', $order->user_id)->first();

        Mail::to($email)->bcc('printshopeld@gmail.com')->send(new newCheckout($order, $image, $user));

        return redirect()->route('home')->with('message', 'Your order has been placed Successfully.');
    }

    public function mpesaCallback(Request $request)
    {
        $mpesaResponse = $request->json()->all();

        Log::info('Mpesa Callback Full Response:', ['mpesaResponse' => $mpesaResponse]);

        if (!isset($mpesaResponse['Body']['stkCallback'])) {
            return response()->json(['message' => 'Invalid callback structure.'], 400);
        }

        $callback = $mpesaResponse['Body']['stkCallback'];

        if ($callback['ResultCode'] == 0) {
            $metadata = collect($callback['CallbackMetadata']['Item']);

            $items = $metadata->mapWithKeys(function ($item) {
                return [$item['Name'] => $item];
            });

            Log::info('Mpesa Payment Details logging ...');

            try {
                $payment = MpesaPayment::create([
                    'merchant_request_id' => $callback['MerchantRequestID'],
                    'checkout_request_id' => $callback['CheckoutRequestID'],
                    'result_code' => $callback['ResultCode'],
                    'result_desc' => $callback['ResultDesc'],
                    'amount' => $items['Amount']['Value'] ?? null,
                    'mpesa_receipt_number' => $items['MpesaReceiptNumber']['Value'] ?? null,
                    'transaction_date' => isset($items['TransactionDate']['Value'])
                        ? Carbon::createFromFormat('YmdHis', $items['TransactionDate']['Value'])->toDateTimeString()
                        : null,
                    'phone_number' => $items['PhoneNumber']['Value'] ?? null,
                    'status' => 'Completed',
                ]);

                Log::info('Payment successfully recorded:', ['payment' => $payment]);

                return response()->json(['message' => 'Payment received and recorded.'], 200);
            } catch (\Exception $e) {
                Log::error('Payment Insertion Failed:', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'Error saving payment.'], 500);
            }
        } else {
            Log::warning('Mpesa Transaction Failed:', ['ResultCode' => $callback['ResultCode'], 'Reason' => $callback['ResultDesc']]);

            MpesaPayment::create([
                'merchant_request_id' => $callback['MerchantRequestID'],
                'checkout_request_id' => $callback['CheckoutRequestID'],
                'result_code' => $callback['ResultCode'],
                'result_desc' => $callback['ResultDesc'],
                'status' => 'Failed',
            ]);

            return response()->json(['message' => 'Transaction failed', 'reason' => $callback['ResultDesc']], 200);
        }
    }
}
