@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
    <div class="container my-4">
        <h2 class="mb-4 text-center">Giỏ Hàng</h2>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="row g-4" id="cart-items">
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; @endphp
                    <div class="col-md-6 col-lg-4 cart-item" data-id="{{ $id }}">
                        <div class="card shadow-sm h-100 rounded-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-4">
                                    @if(isset($item['image']))
                                        <img src="{{ asset('storage/ProductsImage/' . $item['image']) }}"
                                            class="img-fluid rounded-start" style="height:100%; object-fit:cover;"
                                            alt="{{ $item['name'] }}">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:100px;">
                                            <i class="fas fa-utensils fa-2x text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-2">
                                        <h5 class="card-title">{{ $item['name'] }}</h5>
                                        <p class="card-text text-danger fw-bold">Đơn giá: <span
                                                class="item-price">{{ number_format($item['price'], 0, ',', '.') }}₫</span></p>

                                        <!-- Số lượng -->
                                        <div class="d-flex align-items-center mb-2">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm decrement rounded-circle">-</button>
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                class="form-control mx-2 text-center item-quantity" style="width:60px;">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm increment rounded-circle">+</button>
                                        </div>

                                        <!-- Thành tiền -->
                                        <p class="mb-2">Thành tiền: <span
                                                class="item-subtotal">{{ number_format($subtotal, 0, ',', '.') }}₫</span></p>

                                        <!-- Xóa món -->
                                        <button type="button" class="btn btn-sm btn-danger w-100 remove-item">Xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $total += $subtotal; @endphp
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Tổng tiền: <span id="cart-total" class="text-primary">{{ number_format($total, 0, ',', '.') }}₫</span></h4>
                <div>
                    <a href="{{ route('menu') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Quay lại Menu
                    </a>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Đặt hàng
                    </a>
                </div>
            </div>
        @else
            <p class="text-center">Giỏ hàng trống. <a href="{{ route('menu') }}">Tiếp tục mua sắm</a></p>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function updateCartTotal() {
                let total = 0;
                document.querySelectorAll('.cart-item').forEach(function (card) {
                    const subtotalText = card.querySelector('.item-subtotal').innerText.replace(/\./g, '').replace('₫', '');
                    total += parseInt(subtotalText);
                });
                document.getElementById('cart-total').innerText = total.toLocaleString('vi-VN') + '₫';
            }

            // + / - số lượng
            document.querySelectorAll('.cart-item').forEach(function (card) {
                const incrementBtn = card.querySelector('.increment');
                const decrementBtn = card.querySelector('.decrement');
                const quantityInput = card.querySelector('.item-quantity');

                incrementBtn.addEventListener('click', function () {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    updateQuantity(card.dataset.id, quantityInput.value, card);
                });

                decrementBtn.addEventListener('click', function () {
                    let qty = parseInt(quantityInput.value);
                    if (qty > 1) {
                        quantityInput.value = qty - 1;
                        updateQuantity(card.dataset.id, quantityInput.value, card);
                    }
                });

                // Xóa món
                card.querySelector('.remove-item').addEventListener('click', function () {
                    removeItem(card.dataset.id, card);
                });
            });

            // Ajax cập nhật số lượng
            function updateQuantity(id, quantity, card) {
                fetch(`{{ url('/cart/${id}') }}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ quantity: quantity })
                })
                    .then(res => res.json())
                    .then(data => {
                        card.querySelector('.item-subtotal').innerText = parseInt(data.subtotal).toLocaleString('vi-VN') + '₫';
                        updateCartTotal();
                    });
            }

            // Ajax xóa món
            function removeItem(id, card) {
                fetch(`{{ url('/cart/${id}') }}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                    .then(res => res.json())
                    .then(data => {
                        card.remove();
                        updateCartTotal();
                    });
            }

        });
    </script>
@endsection

@section('styles')
    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .decrement,
        .increment {
            width: 30px;
            height: 30px;
            padding: 0;
            font-weight: bold;
        }
    </style>
@endsection