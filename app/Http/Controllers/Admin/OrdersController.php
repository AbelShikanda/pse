<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\orderApproval;
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
            'orderItems.products.ProductImage',
        ])
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('admin.orders.index', with([
            'orders' => $orders,
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('admin.orders.show');
    }

    /**
     * Display the specified resource.
     */
    public function update(Request $request, $id)
    {
        try {
            $order = Orders::with('user')->find($id);
            $order->complete = 1;
            $order->save();

            $email = User::where('id', $order->user->id)->pluck('email')->first();

            Mail::to($email)
                ->send(new orderApproval($order));

            if (!$order) {
                DB::rollBack();

                return back()->with('message', 'Something went wrong while saving data');
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
        // Find the order by ID
        $order = Orders::findOrFail($id);

        // Check if the order was created more than 7 days ago and is not confirmed
        if ($order->complete == 0 && $order->created_at->diffInDays(now()) > 3) {
            $order->delete();  // Delete the order
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        }

        return redirect()->route('orders.index')->with('error', 'Order cannot be deleted.');
    }
}
