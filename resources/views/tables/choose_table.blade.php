@extends('layouts.app')

@section('title', 'Chọn bàn')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Chọn bàn trước khi gọi món</h2>

        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <form action="{{ route('set.table') }}" method="POST" class="w-50 mx-auto">
            @csrf
            <div class="mb-3">
                <label for="table_id" class="form-label">Chọn bàn</label>
                <select name="table_id" id="table_id" class="form-select" required>
                    <option value="">-- Chọn bàn --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}" {{ in_array($table->status, ['occupied', 'reserved']) ? 'disabled' : '' }}>
                            Bàn {{ $table->table_number }}
                            (Số người: {{ $table->capacity }}, Trạng thái: {{ ucfirst($table->status) }})
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Xác nhận</button>
            </div>
        </form>
    </div>
@endsection
