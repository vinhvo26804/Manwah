@extends('layouts.app') <!-- Thay bằng layout của bạn -->

@section('content')
<div class="container">
    <h2>Thanh Toán MoMo - Nhập Thông Tin Thẻ (Test)</h2>
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    
    <form action="{{ route('payment.momo.simulate', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Số Thẻ:</label>
            <input type="text" name="card_number" class="form-control" value="{{old('card_number')}}" required>
        </div>
        <div class="form-group">
            <label>Tên Chủ Thẻ:</label>
            <input type="text" name="card_holder" class="form-control" value="{{old('card_holder')}}" required>
        </div>
        <div class="form-group">
            <label>Ngày Hết Hạn (MM/YY):</label>
            <input type="text" name="expiry" class="form-control" value="{{old('expiry')}}" required>
        </div>
        <div class="form-group">
            <label>CVV:</label>
            <input type="text" name="cvv" class="form-control" value="{{old('cvv')}}" required>
        </div>
        <button type="submit" class="btn btn-primary">Xác Nhận Thanh Toán</button>
    </form>
    
    <p><strong>Lưu ý:</strong> Trong production, bạn sẽ redirect đến trang MoMo thật. Đây chỉ là giả lập để test.</p>
      <div class="test-info">
                <h4>🧪 Thông tin test MoMo Sandbox:</h4>
                <p><strong>Thẻ test:</strong> 9704000000000018</p>
                <p> <strong>Tên chủ thẻ </strong>NGUYEN VAN A</p>
                <p><strong>Mật khẩu/OTP:</strong> 123456</p>
                <p><strong>ngày hết hạn:</strong> 03/07</p>
                <p> <strong>CVV</strong> 123</p>
            </div>
</div>
@endsection