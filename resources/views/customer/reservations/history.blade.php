@extends('layouts.app')

@section('content')
<style>
    /* --- CSS Tùy chỉnh cho Lịch sử đặt bàn (Manwah Style) --- */
    
    :root {
        --primary-color: #c0392b;
        --secondary-color: #e74c3c;
    }

    /* 1. Card Container */
    .history-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: #fff;
    }

    /* 2. Header Gradient */
    .history-header {
        background: linear-gradient(135deg, #c0392b, #e74c3c); /* Màu đỏ cam chủ đạo */
        padding: 25px 30px 18px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
    }

    .history-title {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.4rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .history-subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .btn-back {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
        border: 1px solid rgba(255,255,255,0.4);
        padding: 6px 16px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(0,0,0,0.05);
        white-space: nowrap;
    }

    .btn-back i {
        font-size: 0.85rem;
    }

    .btn-back:hover {
        background-color: white;
        color: #c0392b;
    }

    /* 2.1 Thanh filter */
    .history-filters {
        background: rgba(255,255,255,0.08);
        margin: 0 -30px -8px;
        padding: 10px 30px 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 150px;
    }

    .filter-label {
        color: rgba(255,255,255,0.85);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input,
    .filter-select {
        border-radius: 999px;
        border: none;
        padding: 6px 12px;
        font-size: 0.85rem;
        min-height: 32px;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.7);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        margin-left: auto;
    }

    .btn-filter {
        border-radius: 999px;
        border: none;
        padding: 7px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        background: #ffffff;
        color: #c0392b;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .btn-filter:hover {
        background: #fceae8;
    }

    .btn-reset {
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid rgba(255,255,255,0.7);
        background: transparent;
        color: #fff;
        cursor: pointer;
    }

    .btn-reset:hover {
        background: rgba(255,255,255,0.16);
    }

    /* 3. Bảng (Table) */
    .custom-table {
        margin-bottom: 0;
        width: 100%;
    }

    .custom-table thead th {
        background-color: #f8f9fa;
        color: #7f8c8d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-bottom: 2px solid #eee;
        padding: 12px 15px;
        white-space: nowrap;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease-in-out;
    }

    .custom-table tbody tr:hover {
        background-color: #fff5f5; /* Màu nền đỏ rất nhạt khi di chuột */
        transform: scale(1.003); /* Hiệu ứng nổi nhẹ */
    }

    .custom-table td {
        padding: 12px 15px;
        vertical-align: middle;
        color: #2c3e50;
        border-bottom: 1px solid #f1f1f1;
        font-size: 0.95rem;
    }

    /* 4. Các cột đặc biệt */
    .col-id {
        color: #c0392b;
        font-weight: 800;
        font-size: 0.95rem;
    }

    .col-time {
        font-weight: 600;
    }

    .col-date {
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    /* 5. Trạng thái (Badge) */
    .status-badge {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-pending { background-color: #fff3cd; color: #856404; }
    .status-confirmed { background-color: #d4edda; color: #155724; }
    .status-cancelled { background-color: #f8d7da; color: #721c24; }
    .status-completed { background-color: #d1ecf1; color: #0c5460; }

    /* 6. Trạng thái trống */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }
    
    .btn-start-now {
        background-color: #c0392b;
        color: white;
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(192, 57, 43, 0.3);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    
    .btn-start-now:hover {
        background-color: #a93226;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .icon-muted {
        font-size: 2.5rem;
        color: #e0e0e0;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .history-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>

<div class="container my-5">

    <div class="history-card">
        {{-- Header + Filter --}}
        <div class="history-header">
            <div class="flex-grow-1">
                <h2 class="history-title">Lịch sử đặt bàn</h2>
                <p class="history-subtitle mb-0">
                    Xem lại và lọc những lần bạn đã đặt bàn tại Manwah
                </p>
            </div>

            <a href="{{ url('/') }}" class="btn-back">
                <i class="fas fa-angle-left"></i> Về trang chủ
            </a>
        </div>

        {{-- Thanh filter --}}
        <form method="GET" action="{{ route('reservations.history') }}">
            <div class="history-filters">
                <div class="filter-group">
                    <span class="filter-label">Mã đơn</span>
                    <input
                        type="text"
                        name="code"
                        class="filter-input"
                        placeholder="#123"
                        value="{{ $filters['code'] ?? '' }}"
                    >
                </div>

                <div class="filter-group">
                    <span class="filter-label">Từ ngày</span>
                    <input
                        type="date"
                        name="date_from"
                        class="filter-input"
                        value="{{ $filters['date_from'] ?? '' }}"
                    >
                </div>

                <div class="filter-group">
                    <span class="filter-label">Đến ngày</span>
                    <input
                        type="date"
                        name="date_to"
                        class="filter-input"
                        value="{{ $filters['date_to'] ?? '' }}"
                    >
                </div>

                <div class="filter-group">
                    <span class="filter-label">Trạng thái</span>
                    <select name="status" class="filter-select">
                        <option value="">Tất cả</option>
                        <option value="pending"   @selected(($filters['status'] ?? '') === 'pending')>Chờ xác nhận</option>
                        <option value="confirmed" @selected(($filters['status'] ?? '') === 'confirmed')>Đã xác nhận</option>
                        <option value="cancelled" @selected(($filters['status'] ?? '') === 'cancelled')>Đã hủy</option>
                        <option value="completed" @selected(($filters['status'] ?? '') === 'completed')>Hoàn tất</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Lọc
                    </button>

                    <a href="{{ route('reservations.history') }}" class="btn-reset">
                        Xóa lọc
                    </a>
                </div>
            </div>
        </form>

        {{-- Body --}}
        @if ($reservations->isEmpty())
            <div class="empty-state">
                <i class="fas fa-clipboard-list icon-muted"></i>
                <h5 class="mb-2">Không tìm thấy đơn đặt bàn nào</h5>
                <p class="mb-4">Thử thay đổi điều kiện lọc hoặc đặt một bàn mới để bắt đầu trải nghiệm.</p>
                <a href="{{ route('reservations.create') }}" class="btn-start-now">
                    <i class="fas fa-utensils"></i> Đặt bàn ngay
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th class="text-center">Mã đơn</th>
                            <th>Thời gian</th>
                            <th class="text-center">Số khách</th>
                            <th class="text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $r)
                            @php
                                $statusClass = [
                                    'pending'   => 'status-pending',
                                    'confirmed' => 'status-confirmed',
                                    'cancelled' => 'status-cancelled',
                                    'completed' => 'status-completed',
                                ][$r->status] ?? 'status-pending';

                                $statusLabel = [
                                    'pending'   => 'Chờ xác nhận',
                                    'confirmed' => 'Đã xác nhận',
                                    'cancelled' => 'Đã hủy',
                                    'completed' => 'Hoàn tất',
                                ][$r->status] ?? ucfirst($r->status);
                            @endphp

                            <tr>
                                {{-- Mã đơn --}}
                                <td class="text-center col-id">
                                    #{{ $r->id }}
                                </td>

                                {{-- Thời gian --}}
                                <td>
                                    <div class="col-time">
                                        <i class="far fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($r->reservation_time)->format('H:i') }}
                                    </div>
                                    <div class="col-date">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($r->reservation_date)->format('d/m/Y') }}
                                    </div>
                                </td>

                                {{-- Số khách --}}
                                <td class="text-center">
                                    <strong>{{ $r->guest_count }}</strong> khách
                                </td>

                                {{-- Trạng thái --}}
                                <td class="text-center">
                                    <span class="status-badge {{ $statusClass }}">
                                        @if ($r->status === 'pending')
                                            <i class="fas fa-clock"></i>
                                        @elseif ($r->status === 'confirmed')
                                            <i class="fas fa-check-circle"></i>
                                        @elseif ($r->status === 'cancelled')
                                            <i class="fas fa-times-circle"></i>
                                        @elseif ($r->status === 'completed')
                                            <i class="fas fa-flag-checkered"></i>
                                        @endif
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
