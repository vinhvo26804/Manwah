<?php
namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        // $cart = Cart::with('items.product')->where('user_id',Auth::id())->first();
        $cart = Cart::firstOrCreate(['user_id'=>Auth::id]);
        $cart->load('items.product');
        return view('cart.index', compact('cart'));
    }  

    public function add(Request $request, $productId) {
        $product = Product::findOrFail($productId); // Tìm sản phẩm theo ID, nếu không có thì báo lỗi 404;
        $cart = Cart::firstOrCreate(['user_id'=>Auth::id()]);
        $item = $cart->items() -> where('product_id', $productId) -> first()   ;
        if($item){
            $item-> increment('quantity', $request->input('quantity', 1));


        } else{
            $item()->create([
                'product_id'=>$productId,
                'quantity'=>$request->input('quantity',1)
            ]);
        // }
        // $item = $cart::firstOrNew([
        //     'cart_id'=>$cart->id,
        //     'product_id'=>$productId
        // ]);
        // $item->quantity = $request->input('quantity',1);
        // $item->save();
        //SỬ DỤNG firstOrNew() để tìm hoặc tạo mới CartItem
        }

        return redirect()->route('cart.index')->with('success','Đã thêm vào giỏ');
    }
        public function update(Request $request, $itemId) {
            $item = CartItem::findOrFail($itemId);
            $request -> validate(['quantity'=> 'requied|integer|mi:1']);
            $item->update(['quatity' => $request ->quantity]);
            return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công');
        }

    public function remove($itemId) {
        // CartItem::where('id',$itemId)->whereHas('cart',fn($q)=>$q->where('user_id',Auth::id()))->delete();
        // return back()->with('success','Đã xóa sản phẩm');
        $item = CartItem::findOrFail($itemId);
        $item->delete();

        return redirec()->route('cart.index')->with('success', 'Đã xóa sản phẩm');
    }
}
