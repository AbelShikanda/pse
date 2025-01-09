<?php

namespace App\Http\Controllers;

use App\Mail\newCheckout;
use App\Models\Cart;
use App\Models\Order_Items;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{/**
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
        if (!Session::has('cart')) {
            return redirect()->route('catalog');
        }

        $product = ProductImages::find($id);
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $request->validate([
            'mpesa_ref' => 'alpha_num|unique:orders,reference|max:10|min:10',
            'total' => '',
            'first_name' => '',
            'last_name' => '',
            'landmark' => '',
            'house_no' => '',
            'estate' => '',
            'phone' => '',
            'town' => '',
        ]);

        $order = new Orders();
        $order->tracking_No = serialize($cart);
        $order->price = $request->total;
        $order->reference = $request->total; //'SJ48VKFUQQ';
        $order->user_id = Auth::user()->uuid;

        Auth::user()->order()->save($order);

        $order_items = [];
        foreach ($cart->items as $id => $item) {
            $order_items[] = [
                'order_id' => $order->id,
                'product_id' => $item['item']['products']['0']['id'],
                'color_id' => $request->color,
                'size_id' => $request->size,
                'quantity' => $item['qty'],
                'price' => $item['price'],
            ];
        }
        Order_Items::insert($order_items);

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
        // dd($image);

        Mail::to($email)
            ->bcc('printshopeld@gmail.com')
            ->send(new newCheckout($order, $image, $user));



        return redirect()->route('home')->with('message', 'Your order has been placed Successfully.');
    }
}
