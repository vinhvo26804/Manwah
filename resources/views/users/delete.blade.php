@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-danger">Xác nhận xóa User</h1>

    <div class="card">
        <div class="card-body">
            <p>Bạn có chắc muốn xóa user sau?</p>

            <ul>
                <li><strong>ID:</strong> {{ $user->id }}</li>
                <li><strong>Họ tên:</strong> {{ $user->full_name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Role:</strong> {{ ucfirst($user->role) }}</li>
            </ul>

            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Xác nhận xóa</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
    
@endsection
