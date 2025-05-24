@extends('Admin.layout')

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
    
    .btn-primary {
        background: linear-gradient(135deg, #334155 0%, #0F172A 100%);
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(15,23,42,0.10);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #0F172A 0%, #334155 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(15,23,42,0.20);
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
    
    .btn-info {
        background: rgba(56,189,248,0.1);
        border: 1px solid rgba(56,189,248,0.2);
        color: #38bdf8;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-info:hover {
        background: rgba(56,189,248,0.2);
        transform: translateY(-2px);
    }
    
    .btn-success {
        background: rgba(16,185,129,0.1);
        border: 1px solid rgba(16,185,129,0.2);
        color: #10b981;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        background: rgba(16,185,129,0.2);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    
    .rating-badge {
        background: rgba(255,193,7,0.1);
        color: #ffc107;
        padding: 0.3rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
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
    <div class="page-header">إدارة المتاجر</div>
    
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
        <form method="GET" action="{{ route('admin.stores.index') }}">
            <div class="row align-items-end">
                <div class="col-md-6 mb-3">
                    <label for="search" class="form-label">البحث حسب الاسم</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ $search ?? '' }}" placeholder="أدخل اسم المتجر">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">الحالة</label>
                    <select name="status" id="status" class="form-select">
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
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

    <!-- Store Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>الإجراءات</th>
                        <th>الحالة</th>
                        <th>التقييم</th>
                        <th>الاسم</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stores as $store)
                    <tr>
                        <td>
                            <a href="{{ route('admin.stores.show', $store->id) }}" class="btn btn-info" title="عرض التفاصيل">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $store->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    <i class="fa {{ $store->is_active ? 'fa-check-circle' : 'fa-times-circle' }} me-2"></i>
                                    {{ $store->is_active ? 'نشط' : 'غير نشط' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="rating-badge">
                                <i class="fa fa-star me-1"></i>
                                {{ $store->rating }}
                            </span>
                        </td>
                        <td>{{ $store->name }}</td>
                        <td>#{{ $store->id }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fa fa-store"></i>
                                <p>لا توجد متاجر متاحة.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Links -->
    {{ $stores->appends(['search' => $search, 'status' => $status])->links() }}
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