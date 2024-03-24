<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // save the order
    public function saveOrder(Request $request)
    {
        // validate request
        $request->validate([
            'payment_amount' => 'required',
            'price' => 'required',
            'sub_total' => 'required',
            'tax' => 'required',
            'discount' => 'required',
            'service_charge' => 'required',
            'total' => 'required',
            'payment_method' => 'required',
            'total_item' => 'required',
            'id_kasir' => 'required',
            'nama_kasir' => 'required',
            'transaction_time' => 'required',
        ]);

        $order = Order::create([
            'payment_amount' => $request->payment_amount,
            'price' => $request->price,
            'sub_total' => $request->sub_total,
            'tax' => $request->tax,
            'discount' => $request->discount,
            'service_charge' => $request->service_charge,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
            'total_item' => $request->total_item,
            'id_kasir' => $request->id_kasir,
            'nama_kasir' => $request->nama_kasir,
            'transaction_time' => $request->transaction_time,
        ]);

        // create order items
        foreach ($request->order_items as $item)
        {
            OrderItem::create([
                'id_order' => $order->id,
                'id_product' => $item['id_product'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order,
        ], 200);
    }
}
