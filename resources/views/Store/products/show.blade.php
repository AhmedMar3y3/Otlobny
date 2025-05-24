@extends('Store.layout')
@section('styles')
<style>
    .product-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .product-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .product-header h2 {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .card {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        border-radius: 15px;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(15,23,42,0.30);
    }
    
    .card-body {
        padding: 2rem;
        color: #fff;
    }
    
    .card-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .card-text {
        color: rgba(255,255,255,0.9);
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }
    
    .card-text strong {
        color: #fff;
        font-weight: 500;
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateY(-2px);
    }
    
    .image-upload-square {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        width: 250px; 
        height: 250px;
        border-radius: 15px;
        margin: 0 auto;
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.2);
    }
    
    .image-upload-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 13px;
    }
    
    .no-image {
        color: rgba(255,255,255,0.5);
        font-size: 1.1rem;
        text-align: center;
        padding: 2rem;
    }
</style>
@endsection

@section('main')
<div class="product-container" style="direction: rtl;">
    <div class="product-header">
        <h2>تفاصيل المنتج</h2>
    </div>

    <!-- Image Container -->
    <div class="text-center mb-4">
        @if($product->image)
            <div class="image-upload-square">
                <img src="{{ asset('/images/product/' . basename($product->image)) }}" alt="Image">
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <p class="no-image">لا توجد صورة متاحة</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Product Details -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text"><strong>الوصف:</strong> {{ $product->description }}</p>
            {{-- <p class="card-text"><strong>الكمية:</strong> {{ $product->quantity }}</p> --}}
            <p class="card-text"><strong>السعر:</strong> {{ $product->price }}</p>
            @if($product->discount_price)
            <p class="card-text"><strong>سعر الخصم:</strong> {{ $product->discount_price }}</p>
            @endif
            @if($product->has_stock)
            <p class="card-text"><strong>الكمية المتاحة:</strong> {{ $product->stock }}</p>
            @endif
            <p class="card-text"><strong>الفئة :</strong> {{ $product->category->title }}</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('store.products.index') }}" class="btn btn-secondary">العودة إلى القائمة</a>
    </div>
</div>

@endsection