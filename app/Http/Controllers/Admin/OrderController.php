<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orderdetail;
use App\Models\orderdetailappwatch;
use App\Models\orderdetailmacbook;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth = Auth::user();
        $order = Order::all();
        return view('admin/order/index', compact('auth', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $auth = Auth::user();
        $orderdetail = Orderdetail::where('order_id', $order->id)
            ->select('*')
            ->union(
                orderdetailmacbook::where('order_id', $order->id)
                    ->select('*')
            )
            ->union(
                orderdetailappwatch::where('order_id', $order->id)
                    ->select('*')
            )
            ->get();


        $order_id = $order->id;
        $order_status = $order->status;
        return view('admin/order/order_detail', compact('auth', 'orderdetail', 'order_id', 'order_status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('admin/order');
    }
}
