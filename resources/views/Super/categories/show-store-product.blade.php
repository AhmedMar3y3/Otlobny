@extends('Super.layout')

@section('styles')
<style>
    body, .container {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
    }
    
    .page-header {
        color: #fff;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .alert {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .alert-success {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #ff6b6b;
        border: 1px solid rgba(255,107,107,0.2);
    }
    
    .product-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        margin-bottom: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .product-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 1.5rem;
    }
    
    .product-details {
        color: #fff;
    }
    
    .product-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #fff;
    }
    
    .product-price {
        font-size: 1.5rem;
        color: #38bdf8;
        margin-bottom: 1rem;
    }
    
    .product-status {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .status-active {
        background: rgba(16,185,129,0.1);
        color: #10b981;
        border: 1px solid rgba(16,185,129,0.2);
    }
    
    .status-inactive {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
        border: 1px solid rgba(239,68,68,0.2);
    }
    
    .product-description {
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .product-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .meta-item {
        background: rgba(255,255,255,0.05);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .meta-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .meta-value {
        color: #fff;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: rgba(56,189,248,0.1);
        border: 1px solid rgba(56,189,248,0.2);
        color: #38bdf8;
    }
    
    .btn-primary:hover {
        background: rgba(56,189,248,0.2);
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.2);
        color: #ef4444;
    }
    
    .btn-danger:hover {
        background: rgba(239,68,68,0.2);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
    }
    
    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .page-header { font-size: 1.5rem; }
        .product-title { font-size: 1.5rem; }
        .action-buttons { flex-direction: column; }
        .btn { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('main')
<div class="container text-end" style="direction: rtl;">
    <div class="page-header">تفاصيل المنتج</div>
    
    @if (Session::has('success'))
    <div class="alert alert-success">
        <i class="fa fa-check-circle me-2"></i>
        {{ Session::get('success') }}
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle me-2"></i>
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="product-card">
        <div class="row">
            <div class="col-md-6">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image d-flex align-items-center justify-content-center bg-dark">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-price">{{ number_format($product->price, 2) }} ج.م</div>
                    <div class="product-status {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $product->is_active ? 'متوفر' : 'غير متوفر' }}
                    </div>
                    
                    <div class="product-meta">
                        <div class="meta-item">
                            <div class="meta-label">المتجر</div>
                            <div class="meta-value">{{ $store->name }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">الفئة</div>
                            <div class="meta-value">{{ $category->name }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">تاريخ الإضافة</div>
                            <div class="meta-value">{{ $product->created_at->format('Y/m/d') }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">آخر تحديث</div>
                            <div class="meta-value">{{ $product->updated_at->format('Y/m/d') }}</div>
                        </div>
                    </div>
                    
                    @if($product->description)
                        <div class="product-description">
                            {{ $product->description }}
                        </div>
                    @endif
                    
                    <div class="action-buttons">
                        <a href="{{ route('super.categories.store-products', [$category->id, $store->id]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i>
                            العودة للمنتجات
                        </a>
                        <form action="{{ route('super.categories.delete-store-product', [$category->id, $store->id, $product->id]) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="redirect_to" value="{{ route('super.categories.store-products', [$category->id, $store->id]) }}">
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                <i class="fas fa-trash"></i>
                                حذف المنتج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add loading state to form submission
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>جاري التحميل...';
            }
        });
    });
</script>
@endpush
