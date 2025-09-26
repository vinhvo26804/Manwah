<h1>Giỏ hàng</h1>
@if($cart && $cart->items->count())
<ul>
@foreach($cart->items as $item)
    <li>{{ $item->product->name }} x {{ $item->quantity }} - {{ $item->product->price * $item->quantity }} VND
        <form method="POST" action="{{ route('cart.remove',$item->id) }}">
            @csrf @method('DELETE')
            <button>Xóa</button>
        </form>
    </li>
@endforeach
</ul>
<a href="{{ route('orders.checkout') }}">Thanh toán</a>
@else
<p>Giỏ hàng trống</p>
@endif
