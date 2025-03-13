<?php

namespace App\Http\Controllers;

use App\Mail\newWishlist;
use App\Models\Admin;
use App\Models\Orders;
use App\Models\ProductImage;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\Ratings;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $product_id = Wishlist::where('user_id', $user->id)->pluck('product_id');
        // dd($product_id);
        $product_image_id = ProductImages::whereIn('products_id', $product_id)->pluck('id');
        $wishlist = ProductImages::with('products')->whereIn('id', $product_image_id)->get();

        $related_category_ids = Products::whereIn('id', $product_id)->pluck('categories_id');
        $related_products = Products::whereIn('categories_id', $related_category_ids)->take(6)->get();
        $related_product_ids = $related_products->pluck('id');
        $related = ProductImages::whereIn('products_id', $related_product_ids)->take(6)->get();
        // dd($related);

        $orders = Orders::with('orderItems', 'orderItems.products')->where('user_id', $user->id)->latest()->get();
        $orders->transform(function ($order, $key) {
            $order->cart = unserialize($order->tracking_No);
            return $order;
        });
        // dd($orders);

        $ratings = Ratings::where('user_id', $user->id)->first();
        $ratedItems = Ratings::pluck('products_id')->toArray();

        $latest = ProductImages::with('products')
            ->latest()
            ->take(1)
            ->get();

        return view('profile.index', with([
            'latest' => $latest,
            'wishlist' => $wishlist,
            'related' => $related,
            'orders' => $orders,
            'ratings' => $ratings,
            'ratedItems' => $ratedItems,
        ]));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function wishlist(Request $request)
    {
        $productImage_id = $request->product_id;
        $product_id = ProductImages::where('id', $productImage_id)->pluck('products_id')->first();
        $user = Auth::user();

        if (WishList::where('user_id', $user->id)->where('product_id', $product_id)->exists()) {
            return redirect()->back()->with('message', 'Your product has already been added to the wishlist');
        } else {
            $wishlist = new WishList();
            $wishlist->product_id = $product_id;
            $wishlist->user_id = Auth::id();
            $wishlist->save();

            $product = Products::with('ProductImage')->find($product_id);

            Mail::to('printshopeld@gmail.com')
                ->send(new newWishlist($product));

            return redirect()->back()->with('message', 'Your product has been successfully added to the wishlist');
        }
    }

    public function deleteWish(Request $request)
    {
        $del = $request->product_id;
        $dele = Wishlist::where('product_id', $del)->first();
        $dele->delete();

        return redirect()->route('profile')->with('message', 'The item has been deleted Successfully.');
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'town' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'town' => $request->town,
            'location' => $request->location,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
