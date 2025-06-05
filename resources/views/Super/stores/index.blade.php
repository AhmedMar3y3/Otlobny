@extends('Super.layout')
@section('styles')
<style>
    body, .container {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
    }
    .page-header {
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
    }
    .alert-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    .alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    .filter-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-label i {
        color: #3b82f6;
        font-size: 0.9rem;
    }
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 0.875rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.1);
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        color: #fff;
    }
    .form-control::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    .btn-search {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.875rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
    }
    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .table-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    .table {
        color: #fff;
        margin-bottom: 0;
    }
    .table thead th {
        border-bottom: 2px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        font-weight: 500;
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
    }
    .btn-action {
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-left: 0.5rem;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
    }
    .btn-view:hover {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        border: none;
    }
    .btn-delete:hover {
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .btn-change {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
    }
    .btn-change:hover {
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }
    .input-group {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 0.25rem;
    }
    .input-group .form-select {
        border: none;
        background: transparent;
    }
    .input-group .form-select:focus {
        box-shadow: none;
    }
    .text-danger {
        color: #ef4444 !important;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .text-danger::before {
        content: '!';
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        background: #ef4444;
        color: #fff;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: bold;
    }
    .pagination {
        margin-top: 2rem;
    }
    .pagination .page-item .page-link {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border-color: transparent;
    }
    .pagination .page-item .page-link:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
    }
    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem 0;
        }
        .page-header {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .filter-card {
            padding: 1rem;
        }
        .table-container {
            padding: 1rem;
        }
        .table thead th,
        .table tbody td {
            padding: 0.75rem;
        }
    }
</style>
@endsection
@section('main')
<div class="page-container" dir="rtl">
    <h2 class="page-header">جميع المتاجر</h2>

    <!-- Success/Error Messages -->
    @if (Session::has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Search and Filter Form -->
    <div class="filter-card">
        <form method="GET" action="{{ route('super.stores.index') }}">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="search" class="form-label">
                        <i class="fas fa-search"></i>
                        البحث حسب الاسم
                    </label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}" placeholder="أدخل اسم المتجر">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">
                        <i class="fas fa-filter"></i>
                        الحالة
                    </label>
                    <select name="status" id="status" class="form-select">
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-search">
                        <i class="fas fa-search me-2"></i>
                        بحث
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Store Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>الإجراءات</th>
                    <th>المسؤول</th>
                    <th>التقييم</th>
                    <th>الاسم</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stores as $store)
                <tr>
                    <td>
                        <a href="{{ route('super.stores.show', $store->id) }}" class="btn btn-action btn-view">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('super.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-action btn-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @if($store->whatsapp)
                        <a href="https://wa.me/{{ $store->whatsapp }}" target="_blank" class="btn btn-action" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: #fff; border: none;">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('super.stores.changeAdmin', $store->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <select name="admin_id" class="form-select" required>
                                    <option value="" {{ is_null($store->admin_id) ? 'selected' : '' }}>لا يوجد مسؤول</option>
                                    @foreach ($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ $store->admin_id == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }} ({{ $admin->area }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-change">
                                    <i class="fas fa-exchange-alt me-2"></i>
                                    تغيير
                                </button>
                            </div>
                            @error('admin_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </form>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-star text-warning me-2"></i>
                            {{ $store->rating }}
                        </div>
                    </td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->id }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">لا توجد متاجر متاحة.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $stores->appends(['search' => $search, 'status' => $status])->links() }}
    </div>
</div>
@endsection