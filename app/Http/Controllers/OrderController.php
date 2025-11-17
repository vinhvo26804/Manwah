<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantTable;

class OrderController extends Controller
{
    // Hiển thị form thanh toán / hóa đơn
    public function create()
    {
        $tableId = session('table_id');
        if (!$tableId) {
            return redirect()->route('menu')->with('error', 'Chưa chọn bàn');
        }

        $cart = Cart::with('items.product')->where('table_id', $tableId)->first();
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('menu')->with('error', 'Giỏ hàng đang trống');
        }

        return view('orders.create', compact('cart', 'tableId'));
    }

    // Lưu hóa đơn
    public function store(Request $request)
    {
        $tableId = session('table_id');
        $cart = Cart::with('items')->where('table_id', $tableId)->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('menu')->with('error', 'Giỏ hàng đang trống');
        }

        // Tạo hóa đơn
        $order = Order::create([
            'table_id' => $tableId,
            'total' => $cart->items->sum(fn($i) => $i->quantity * $i->product->price),
            'status' => 'pending',
        ]);

        // Chuyển cart_items sang order_items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Xóa giỏ hàng
        $cart->items()->delete();
        $cart->delete();

        // Cập nhật trạng thái bàn
        RestaurantTable::where('id', $tableId)->update(['status' => 'occupied']);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Đã tạo hóa đơn thành công');
    }

    // Xem hóa đơn
    public function show($id)
    {
        $order = Order::with('items.product', 'table')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
