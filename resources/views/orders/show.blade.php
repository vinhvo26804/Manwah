<h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
<p>Bàn: {{ $order->table->table_number ?? 'Không có' }}</p>
<p>Tổng tiền: {{ number_format($order->total_amount,0,'.','.') }} VND</p>
<p>Trạng thái: {{ ucfirst($order->status) }}</p>

<h2>Món ăn</h2>
<ul>
@foreach($order->items as $item)
    <li>{{ $item->product->name }} x {{ $item->quantity }} - {{ number_format($item->price,0,'.','.') }} VND</li>
@endforeach
</ul>

<a href="{{ route('orders.index') }}">Quay lại danh sách</a>
<a href="{{ route('orders.edit',$order->id) }}">Sửa đơn hàng</a>
<form action="{{ route('orders.destroy',$order->id) }}" method="POST" style="display:inline">
    @csrf @method('DELETE')
    <button onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa đơn hàng</button> 