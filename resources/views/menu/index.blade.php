@extends('layouts.app')

@section('title', 'Menu nhà hàng')

@section('content')
<div class="container my-4">
    <h1 class="mb-4 text-center">Thực đơn</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100 rounded-3">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-utensils fa-2x text-secondary"></i>
                </div>
                @endif

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product->price, 0, '.', '.') }} VND</p>
                    </div>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form mt-2">
                        @csrf
                        <div class="quantity-control d-flex align-items-center justify-content-center mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm decrement rounded-circle">-</button>
                            <input type="text" name="quantity" value="0" readonly class="form-control quantity-input mx-2 text-center" style="width: 50px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm increment rounded-circle">+</button>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill">Thêm vào giỏ</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart-form').forEach(function(form){
        const incrementBtn = form.querySelector('.increment');
        const decrementBtn = form.querySelector('.decrement');
        const quantityInput = form.querySelector('.quantity-input');

        incrementBtn.addEventListener('click', function(){
            let qty = parseInt(quantityInput.value);
            quantityInput.value = qty + 1;
        });

        decrementBtn.addEventListener('click', function(){
            let qty = parseInt(quantityInput.value);
            if(qty > 0) quantityInput.value = qty - 1;
        });
    });
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
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
.quantity-control button {
    width: 32px;
    height: 32px;
    font-weight: bold;
}
.quantity-control input {
    font-weight: bold;
}
</style>
@endsection
