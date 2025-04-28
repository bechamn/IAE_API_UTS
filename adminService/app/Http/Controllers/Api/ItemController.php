<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }
    
    public function store(Request $request) {
        return Item::create($request->all());
    }

    public function update(Request $request, $id) {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return $item;
    }

    public function destroy($id) {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Item deleted']);
    }
}