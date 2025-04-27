<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // Add this import
use Illuminate\Support\Facades\Auth; // Add this import

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Start transaction
        DB::beginTransaction(); // Changed from \DB to DB

        try {
            $order = new Order();
            $order->user_id = Auth::id(); // Changed from auth()->id() to Auth::id()
            $order->shipping_address = $request->shipping_address;
            $order->status = 'pending';
            $order->total_amount = 0;
            $order->save();

            $total = 0;

            foreach ($request->items as $item) {
                $product = Item::find($item['id']);
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for item: {$product->name}");
                }

                $order->items()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price
                ]);

                $total += $product->price * $item['quantity'];
                
                // Reduce stock
                $product->stock -= $item['quantity'];
                $product->save();
            }

            $order->total_amount = $total;
            $order->save();

            DB::commit(); // Changed from \DB to DB

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order->load('items')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Changed from \DB to DB
            return response()->json([
                'message' => 'Order failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('items')->get(); // Changed from auth() to Auth
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) { // Changed from auth() to Auth
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('items'));
    }
} 