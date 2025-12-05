@extends('layouts.app')

@section('content')

<style>
    /* --- CSS Style cho trang Success (Ticket Style) --- */
    
    .success-container {
        padding: 50px 15px;
    }

    .ticket-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
        position: relative;
    }

    /* Phần đầu: Màu nền đỏ cam */
    .ticket-header {
        background: linear-gradient(135deg, #c0392b, #e74c3c);
        padding: 40px 20px 30px;
        text-align: center;
        color: white;
        position: relative;
    }

    /* Vòng tròn icon dấu tích */
    .icon-circle {
        width: 80px;
        height: 80px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .success-icon {
        color: #27ae60;
        font-size: 40px;
    }

    .main-title {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    /* Phần thân: Chi tiết vé */
    .ticket-body {
        padding: 30px;
    }

    /* Đường kẻ đứt nét giống hóa đơn */
    .dashed-line {
        border-top: 2px dashed #e0e0e0;
        margin: 20px 0;
        position: relative;
    }

    /* Tạo 2 hình bán nguyệt lõm vào ở đường kẻ (hiệu ứng vé) */
    .dashed-line::before, .dashed-line::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #f8f9fa; /* Trùng màu nền trang web */
        border-radius: 50%;
        top: -11px;
    }
    .dashed-line::before { left: -40px; }
    .dashed-line::after { right: -40px; }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 0.95rem;
    }

    .detail-label {
        color: #7f8c8d;
        font-weight: 500;
    }

    .detail-value {
        color: #2c3e50;
        font-weight: 700;
        text-align: right;
    }

    .time-highlight {
        color: #c0392b; /* Màu đỏ thương hiệu */
        font-size: 1.1rem;
    }

    /* Nút bấm */
    .btn-home {
        background: linear-gradient(135deg, #c0392b, #e74c3c);
        color: white;
        border-radius: 30px;
        padding: 12px 35px;
        font-weight: 600;
        border: none;
        box-shadow: 0 5px 15px rgba(192, 57, 43, 0.3);
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .btn-home:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(192, 57, 43, 0.4);
        color: white;
    }

    /* Animation đơn giản */
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow ticket-card">
                <div class="card-header bg-success text-white ticket-header">
                    <div class="icon-circle">
                        <span class="success-icon">
                            ✓
                        </span>
                    </div>
                    <h4 class="mb-0 main-title">Đặt bàn thành công</h4>
                    <p class="mb-0">Cảm ơn bạn đã đặt bàn tại nhà hàng Manwah.</p>
                </div>

                <div class="card-body ticket-body">
                    <h5 class="mt-2 mb-3">Thông tin đặt bàn</h5>

                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Mã đơn:</span>
                            <span class="detail-value">#{{ $reservation->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Khách hàng:</span>
                            {{-- LUÔN dùng customer_name, không phụ thuộc user --}}
                            <span class="detail-value">{{ $reservation->customer_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Số điện thoại:</span>
                            <span class="detail-value">{{ $reservation->customer_phone }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Ngày:</span>
                            <span class="detail-value">{{ $reservation->reservation_date }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Giờ:</span>
                            <span class="detail-value time-highlight">{{ $reservation->reservation_time }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Số khách:</span>
                            <span class="detail-value">{{ $reservation->guest_count }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Trạng thái:</span>
                            <span class="detail-value">{{ ucfirst($reservation->status) }}</span>
                        </li>

                        {{-- Nếu có gắn bàn cụ thể --}}
                        @if ($reservation->restaurantTable)
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Bàn:</span>
                            <span class="detail-value">{{ $reservation->restaurantTable->name }}</span>
                        </li>
                        @endif

                        {{-- Thông tin tài khoản (nếu có đăng nhập) --}}
                        @if ($reservation->user)
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="detail-label">Tài khoản:</span>
                            <span class="detail-value">
                                {{ $reservation->user->full_name ?? $reservation->user->name }}
                                ({{ $reservation->user->email }})
                            </span>
                        </li>
                        @endif
                    </ul>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                            Về trang chủ
                        </a>

                        {{-- Chỉ show lịch sử nếu có user (đăng nhập) --}}
                        @if ($reservation->user)
                            <a href="{{ route('reservations.history') }}" class="btn btn-primary">
                                Xem lịch sử đặt bàn
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
