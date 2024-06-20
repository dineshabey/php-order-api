<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        return view('dashboard');
    }


    public function create(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_value' => 'required|numeric',
        ]);

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'order_value' => $request->order_value,
            'process_id' => rand(1, 10),
            'order_status' => 'Processing'
        ]);

        // ProcessOrder::dispatch($order, $order->process_id);

        return response()->json([
            'Order_ID' => $order->id,
            'Process_ID' => $order->process_id,
            'Status' => 'Order is being processed'
        ]);
    }

    // In OrderController.php
    public function status($id)
    {
        $order = Order::find($id);

        if ($order) {
            return response()->json([
                'Order_ID' => $order->id,
                'Order_Status' => $order->order_status,
                'Process_ID' => $order->process_id
            ]);
        } else {
            return response()->json(['message' => 'Order not found'], 404);
        }
    }
}
