<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::all();
        return response($orders, 201);
    }

    public function store(Request $request)
    {
        $order = Orders::create($request->all());
        return response()->json($order, 201);
    }

    public function show($id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => "Cannot locate order with ID: '$id'"
            ]);
        }
        return response()->json([
            'success' => true,
            'order' => $order
        ], 201);
    }
    public function delete($id)
    {
        $order = Orders::find($id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => "cannot find order with id: '$id'"
            ], 201);
        }
        $order->delete();
        return response()->json([
            'success' => true,
            'message' => "order with id: '$id' deleted",
        ], 201);
    }
}
