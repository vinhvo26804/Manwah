<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\RestaurantTable;

class CartController extends Controller
{
    // Hiển thị giao diện chọn bàn
    public function chooseTable()
    {
        $tables = RestaurantTable::all();
        return view('cart.choose_table', compact('tables'));
    }

    // Gán bàn đã chọn vào session
    // public function setTable(Request $request)
    // {
    //     $request->validate(['table_id' => 'required']);

    //     $table = RestaurantTable::find($request->table_id);

    //     if (!$table) {
    //         return back()->with('error', 'Bàn không tồn tại');
    //     }

    //     // Lưu vào session
    //     session(['table_id' => $table->id]);

    //     return redirect()->route('table.cart', $table->id)
    //         ->with('success', 'Đã chọn bàn thành công!');
    // }

    // Xem giỏ hàng theo bàn
    public function index($tableId)
    {
        $cart = Cart::with('items.product')->where('table_id', $tableId)->first();

        $items = $cart ? $cart->items : collect();

        return view('cart.index', compact('items', 'tableId'));
    }

    // Thêm món vào giỏ hàng theo bàn
    // public function add(Request $request, $tableId)
    // {
    //     $request->validate([
    //         'product_id' => 'required',
    //         'quantity' => 'required|numeric|min:1',
    //     ]);

    //     $cart = Cart::firstOrCreate(['table_id' => $tableId]);

    //     $item = CartItem::where('cart_id', $cart->id)
    //         ->where('product_id', $request->product_id)
    //         ->first();

    //     if ($item) {
    //         $item->quantity += $request->quantity;
    //         $item->save();
    //     } else {
    //         CartItem::create([
    //             'cart_id' => $cart->id,
    //             'product_id' => $request->product_id,
    //             'quantity' => $request->quantity,
    //         ]);
    //     }

    //     return back()->with('success', 'Đã thêm món vào giỏ hàng');
    // }

    public function add(Request $request, $tableId)
    {
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'product_id.*' => 'required|integer',
            'quantity.*' => 'required|integer|min:0',
        ]);

        // Tạo giỏ nếu chưa có
        $cart = Cart::firstOrCreate(['table_id' => $tableId]);

        foreach ($request->product_id as $index => $productId) {

            $qty = $request->quantity[$index];

            // BỎ QUA món có quantity = 0
            if ($qty <= 0)
                continue;

            $item = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($item) {
                $item->quantity += $qty;
                $item->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'quantity' => $qty,
                ]);
            }
        }

        return back()->with('success', 'Đã thêm các món vào giỏ hàng');
    }




    // Cập nhật số lượng
    // CartController.php
    public function update(Request $request, $tableId, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $item = CartItem::findOrFail($id);
        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Đã cập nhật số lượng');
    }


    // Xóa 1 món
    public function remove($tableId, $id)
    {
        CartItem::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa món');
    }


    // Xóa toàn bộ giỏ hàng theo bàn
    public function clear($tableId)
    {
        $cart = Cart::where('table_id', $tableId)->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
}
