<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = intval($request->quantity);

        // Chỉ thêm khi số lượng > 0
        if ($quantity > 0) {
            $cart = session('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $product->image,
                ];
            }

            session(['cart' => $cart]);

            return redirect()->back()->with('success', "Đã thêm $quantity {$product->name} vào giỏ hàng!");
        }

        return redirect()->back()->with('error', 'Vui lòng chọn số lượng lớn hơn 0 để thêm vào giỏ hàng.');
    }


    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        // Lấy hoặc tạo giỏ hàng
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Lấy toàn bộ item trong giỏ
        $items = $cart->items()->with('product')->get();

        return view('cart.index', compact('cart', 'items'));
    }

    // Cập nhật số lượng (Ajax)
    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, intval($request->quantity));
            session(['cart' => $cart]);
            $subtotal = $cart[$id]['price'] * $cart[$id]['quantity'];
            return response()->json(['subtotal' => $subtotal]);
        }
        return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
    }

    // Xóa món (Ajax)
    public function remove($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
    }


}
