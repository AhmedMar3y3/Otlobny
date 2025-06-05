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
    
    .filter-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: none;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        color: #fff;
        padding: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .form-control::placeholder {
        color: rgba(255,255,255,0.5);
    }
    
    .table-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .table {
        color: #fff;
        margin-bottom: 0;
    }
    
    .table thead th {
        background: rgba(255,255,255,0.05);
        color: #94a3b8;
        font-weight: 600;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
    }
    
    .table tbody td {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.05);
        transform: translateY(-2px);
    }
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-info {
        background: rgba(56,189,248,0.1);
        border: 1px solid rgba(56,189,248,0.2);
        color: #38bdf8;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-info:hover {
        background: rgba(56,189,248,0.2);
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.2);
        color: #ef4444;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        background: rgba(239,68,68,0.2);
        transform: translateY(-2px);
    }
    
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
    }
    
    .badge-success {
        background: rgba(16,185,129,0.1);
        color: #10b981;
        border: 1px solid rgba(16,185,129,0.2);
    }
    
    .badge-danger {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
        border: 1px solid rgba(239,68,68,0.2);
    }
    
    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .modal-content {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .close {
        color: #fff;
        text-shadow: none;
        opacity: 0.7;
    }
    
    .close:hover {
        opacity: 1;
    }
    
    .pagination {
        margin-top: 2rem;
        justify-content: center;
    }
    
    .page-link {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .page-link:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    
    .page-item.active .page-link {
        background: #38bdf8;
        border-color: #38bdf8;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .page-header { font-size: 1.5rem; }
        .table-responsive { margin: 0 -1.5rem; }
        .btn-group { flex-direction: column; }
    }
</style>
@endsection

@section('main')
<div class="container text-end" style="direction: rtl;">
    <div class="page-header">منتجات {{ $store->name }}</div>
    
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

    <!-- Search and Filter Form -->
    <div class="filter-card">
        <form method="GET" action="{{ route('super.categories.store-products', [$category->id, $store->id]) }}">
            <div class="row align-items-end">
                <div class="col-md-6 mb-3">
                    <label for="search" class="form-label">البحث حسب الاسم</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="أدخل اسم المنتج">
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-search me-2"></i>
                        بحث
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الصورة</th>
                        <th>اسم المنتج</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                            @else
                                <span class="text-muted">لا توجد صورة</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price, 2) }} ج.م</td>
                        <td>
                            <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                                {{ $product->is_active ? 'متوفر' : 'غير متوفر' }}
                            </span>
                        </td>
                        <td>
                                <a href="{{ route('super.categories.show-store-product', [$category->id, $store->id, $product->id]) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('super.categories.delete-store-product', [$category->id, $store->id, $product->id]) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa fa-box"></i>
                                <p>لا توجد منتجات متاحة.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    {{ $products->appends(['search' => request('search'), 'status' => request('status')])->links() }}
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