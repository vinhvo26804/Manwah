<h1>Tạo đơn hàng mới</h1>
<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    <label>Bàn:</label>
    <select name="table_id">
        <option value="">Không chọn</option>
        @foreach($tables as $table)
            <option value="{{ $table->id }}">{{ $table->table_number }} ({{ $table->status }})</option>
        @endforeach
    </select>

    <h3>Chọn sản phẩm</h3>
    @foreach($products as $product)
        <input type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
        {{ $product->name }} - {{ number_format($product->price,0,'.','.') }} VND
        <input type="number" name="products[{{ $loop->index }}][quantity]" value="1" min="1"><br>
    @endforeach

    <button type="submit">Tạo đơn</button>
</form>
<a href="{{ route('orders.index') }}">Quay lại</a>
