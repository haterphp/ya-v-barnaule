<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()->orderBy('created_at', 'DESC')->paginate(20);
        return view('dashboard.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $order->status = $request->has('approve') ? '1' : '2';
        $order->save();

        return back()->with('alert', [
            'status' => 'success',
            'message' => 'Статус успешно изменен'
        ]);
    }
}
