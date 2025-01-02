<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\orderApproval;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Orders::with([
            'user',
            'orderItems.products.producttype',
            'orderItems.products.color',
            'orderItems.products.size',
        ])
        ->orderBy('created_at', 'DESC')
        ->get();
        // $ordersItems = OrderItems::orderBy('id', 'DESC')->get();
        // $users = User::latest()->get();

        // foreach ($orders as $order) {
        //     foreach ($order->orderItems as $items) {
        //             dump($items->products->producttype);
        //         foreach ($items->products as $prods) {
        //                 // dump($prods->name);
        //         }
        //     }
        // }

        return view('admin.orders.index', with([
            'orders' => $orders,
            // 'ordersItems' => $ordersItems,
            // 'users' => $users,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return view('admin.orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.orders.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin.orders.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $order = Orders::with('user')->find($id);
            $order->complete = 1;
            $order->save();
            
            $email = User::where('id', $order->user->id)->pluck('email')->first();
            
            // Mail::to($email)
            //     ->send(new orderApproval($order));

            if (!$order) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving user data');
            }

            DB::commit();
            return redirect()->route('orders.index')->with('message', 'Order updated Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // return view('admin.orders.index');
    }
}
