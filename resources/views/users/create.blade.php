@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 20px auto;">
    <h2 style="margin-bottom: 20px; text-align:center;">Thêm User mới</h2>

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 15px;">
            <ul style="padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form tạo user --}}
    <form action="{{ route('users.store') }}" method="POST" style="display:flex; flex-direction:column; gap:15px;">
        @csrf

        <div>
            <label>Họ và tên</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required class="form-control">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
        </div>

        <div>
            <label>Mật khẩu</label>
            <input type="password" name="password" required class="form-control">
        </div>

        <div>
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" required class="form-control">
        </div>

        <div>
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
        </div>

        <div>
            <label>Địa chỉ</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
        </div>

        <div>
            <label>Vai trò</label>
            <select name="role" class="form-control">
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
            </select>
        </div>

        <div>
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ngưng hoạt động</option>
            </select>
        </div>

        <button type="submit" style="
            padding:10px;
            border:none;
            background:#007bff;
            color:#fff;
            border-radius:4px;
            cursor:pointer;
        ">
            Thêm User
        </button>
    </form>
</div>
@endsection
