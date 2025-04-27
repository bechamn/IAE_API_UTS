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
    public function index() {
        return Order::all();
    }

    public function confirm($id) {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'confirmed']);
        return response()->json(['message' => 'Order confirmed']);
    }
} 