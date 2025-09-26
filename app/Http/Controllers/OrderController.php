<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Danh sách orders
    public function index()
    {
        $orders = Order::with('items.product','table')->orderBy('order_date','desc')->get();
        return view('orders.index', compact('orders'));
    }

    // Form tạo đơn hàng mới
    public function create()
    {
       $orders = Order::with('item.product','table','user')
       ->orderBy('orderDate','desc')
       ->get();
       return redirect()->route('order.index', compact('orders'));
    }


    // public function checkout(Request $request){
    //     $cart = Cart::with('item.product')->where('user_id',Auth::id())->first();

    //     if(!$cart|| $cart ->empty()){
    //         return redirect()->route('order.index')->with('error', 'giỏ hàng trống');
    //     }
    //     DB::transaction(function () use ($cart,$request){
    //         $total = $cart->items->sum(fn($item) => $item->product->price* $item->quantity);
        
    //         $order = Order::create
    //     )}
    
    // Lưu đơn hàng mới
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'table_id' => 'nullable|exists:restaurant_tables,id',
    //         'products' => 'required|array',
    //         'products.*.id' => 'required|exists:products,id',
    //         'products.*.quantity' => 'required|integer|min:1'
    //     ]);

    //     // Tính tổng tiền
    //     $total = 0;
    //     foreach($request->products as $p){
    //         $product = Product::find($p['id']);
    //         $total += $product->price * $p['quantity'];
    //     }

    //     // Tạo Order
    //     $order = Order::create([
    //         'user_id'=>Auth::id(),
    //         'table_id'=>$request->table_id,
    //         'status'=>'pending',
    //         'total_amount'=>$total
    //     ]);

    //     // Tạo OrderItem
    //     foreach($request->products as $p){
    //         $product = Product::find($p['id']);
    //         OrderItem::create([
    //             'order_id'=>$order->id,
    //             'product_id'=>$product->id,
    //             'quantity'=>$p['quantity'],
    //             'price'=>$product->price
    //         ]);
    //     }

    //     return redirect()->route('orders.index')->with('success','Tạo đơn hàng thành công');
    // }

    // // Xem chi tiết đơn hàng
    // public function show($id)
    // {
    //     $order = Order::with('items.product','table')->findOrFail($id);
    //     return view('orders.show', compact('order'));
    // }

    // // Form sửa order (chỉ status và table)
    // public function edit($id)
    // {
    //     $order = Order::findOrFail($id);
    //     $tables = RestaurantTable::all();
    //     return view('orders.edit', compact('order','tables'));
    // }

    // Cập nhật order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,confirmed,served,completed,cancelled',
            'table_id' => 'nullable|exists:restaurant_tables,id'
        ]);

        $order->update([
            'status'=>$request->status,
            'table_id'=>$request->table_id
        ]);

        return redirect()->route('orders.index')->with('success','Cập nhật đơn hàng thành công');
    }

    // Xóa order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success','Xóa đơn hàng thành công');
    }
}
