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
    
    .form-select {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        color: #fff;
        padding: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        background-color: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.1);
        color: #fff;
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
    
    .btn-group {
        display: flex;
        gap: 0.5rem;
        position: relative;
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
    
    .dropdown-menu {
        background: #1E293B;
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 0.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        position: absolute;
        z-index: 1000;
        min-width: 200px;
        margin-top: 0.5rem;
    }
    
    .dropdown {
        position: relative;
    }
    
    .dropdown-item {
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .dropdown-item:hover {
        background: rgba(255,255,255,0.1);
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
    
    .status-badge {
        padding: 0.3rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-pending { background: rgba(255,193,7,0.1); color: #ffc107; }
    .status-preparing { background: rgba(56,189,248,0.1); color: #38bdf8; }
    .status-shipping { background: rgba(16,185,129,0.1); color: #10b981; }
    .status-delivered { background: rgba(34,197,94,0.1); color: #22c55e; }
    .status-cancelled { background: rgba(239,68,68,0.1); color: #ef4444; }
    
    @media (max-width: 768px) {
        .page-header { font-size: 1.5rem; }
        .table-responsive { margin: 0 -1.5rem; }
        .btn-group { flex-direction: column; }
    }
</style>
@endsection

@section('main')
<div class="container text-end" style="direction: rtl;">
    <div class="page-header">إدارة الطلبات</div>
    
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

    <!-- Status Filter Form -->
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">حالة الطلب</label>
                    <select name="status" id="status" class="form-select">
                        <option value="" {{ $status === null ? 'selected' : '' }}>الكل</option>
                        @foreach (\App\Enums\OrderStatus::cases() as $enumStatus)
                            <option value="{{ $enumStatus->value }}" {{ $status === $enumStatus->value ? 'selected' : '' }}>
                                {{ __('order.' . $enumStatus->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-2"></i>
                        تصفية
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>الإجراءات</th>
                        <th>الحالة</th>
                        <th>المندوب</th>
                        <th>طريقة الدفع</th>
                        <th>السعر</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" 
                                            id="dropdownMenuButton-{{ $order->id }}" 
                                            data-bs-toggle="dropdown" 
                                            data-bs-auto-close="true"
                                            aria-expanded="false">
                                        <i class="fa fa-user-plus me-2"></i>
                                        تعيين مندوب
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                        <li>
                                            <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="px-3 py-2">
                                                    <select name="delegate_id" class="form-select" 
                                                            onchange="this.form.submit()">
                                                        <option value="">اختر مندوب</option>
                                                        @forelse($delegates as $delegate)
                                                        <option value="{{ $delegate->id }}" 
                                                            {{ $order->delegate_id == $delegate->id ? 'selected' : '' }}>
                                                            {{ $delegate->first_name }} {{ $delegate->last_name }}
                                                            @if($delegate->phone)
                                                            - {{ $delegate->phone }}
                                                            @endif
                                                        </option>
                                                        @empty
                                                        <option disabled>لا يوجد مناديب متاحين</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info" title="عرض التفاصيل">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->status->name) }}">
                                {{ __('order.'.$order->status->name) }}
                            </span>
                        </td>
                        <td>
                            @if($order->delegate)
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user me-2"></i>
                                {{ $order->delegate->first_name }} {{ $order->delegate->last_name }}
                            </div>
                            @else
                            <span class="text-muted">لم يتم التعيين</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ __('order.'.$order->pay_type->name) }}
                            </span>
                        </td>
                        <td>{{ number_format($order->total_price, 2) }} ريال</td>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    {{ $orders->appends(['status' => $status])->links() }}
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