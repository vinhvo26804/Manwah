@extends('Layouts.customer')

@section('content')
<style>
    .profile-card {
        max-width: 500px;
        margin: 50px auto;
        border-radius: 12px;
        padding: 30px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .profile-title {
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
    }
    .profile-row {
        margin-bottom: 12px;
    }
</style>

<div class="profile-card">

    <div class="profile-title">👤 Thông tin tài khoản</div>

    {{-- Hiển thị thông tin --}}
    <div id="view-mode">
        <div class="profile-row"><strong>Họ tên:</strong> {{ $user->full_name }}</div>
        <div class="profile-row"><strong>Email:</strong> {{ $user->email }}</div>
        <div class="profile-row"><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</div>
        <div class="profile-row"><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</div>

        <div class="profile-row">
            <strong>Vai trò:</strong>
            @if($user->isAdmin())
                <span class="badge bg-danger">Admin</span>
            @elseif($user->isStaff())
                <span class="badge bg-warning">Staff</span>
            @else
                <span class="badge bg-primary">Customer</span>
            @endif
        </div>

        <button class="btn btn-primary w-100 mt-3" onclick="toggleEdit()">✏️ Sửa thông tin</button>
    </div>

    {{-- Form Edit – Ẩn mặc định --}}
    <div id="edit-mode" style="display: none;">
        <form method="POST" action="{{ route('users.update', $user->id) }}">

            @csrf
    <!-- @method('PUT') -->

            <div class="mb-3">
                <label class="form-label">Họ tên</label>
                <input type="text" name="full_name" class="form-control" value="{{ $user->full_name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="{{ $user->address }}">
            </div>

            <button type="submit" class="btn btn-success w-100">💾 Lưu thông tin</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="toggleEdit()">❌ Hủy</button>
        </form>
    </div>
</div>

<script>
    function toggleEdit() {
        document.getElementById("view-mode").style.display =
            document.getElementById("view-mode").style.display === "none" ? "block" : "none";

        document.getElementById("edit-mode").style.display =
            document.getElementById("edit-mode").style.display === "none" ? "block" : "none";
    }
</script>

@endsection
