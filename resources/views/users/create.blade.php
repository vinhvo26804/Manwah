@extends('layouts.app') {{-- hoặc layouts.master tùy bạn --}}

@section('content')
<div class="container">
    <h2>Thêm User mới</h2>

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tạo user --}}
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div>
            <label>Họ và tên</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
        </div>
        <div>
    <label>Xác nhận mật khẩu</label>
    <input type="password" name="password_confirmation" required>
</div>

        <div>
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>

        <div>
            <label>Địa chỉ</label>
            <textarea name="address">{{ old('address') }}</textarea>
        </div>

        <div>
            <label>Vai trò</label>
            <select name="role">
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
            </select>
        </div>

        <div>
            <label>Trạng thái</label>
            <select name="status">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ngưng hoạt động</option>
            </select>
        </div>

        <button type="submit">Thêm User</button>
    </form>
</div>
@endsection
