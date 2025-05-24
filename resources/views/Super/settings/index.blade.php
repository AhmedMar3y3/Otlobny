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
    .settings-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        margin-bottom: 2rem;
    }
    .settings-card-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .settings-card-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    }
    .settings-card-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .settings-card-title i {
        color: #3b82f6;
    }
    .btn-edit-mode {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-edit-mode:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
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
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 0.875rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .form-control:focus {
        background: rgba(255,255,255,0.1);
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        color: #fff;
    }
    .form-control::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    .btn-save {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .form-text {
        color: #94a3b8;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    .settings-value {
        color: #fff;
        font-size: 1.1rem;
        padding: 0.875rem 1rem;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        margin-top: 0.5rem;
    }
    .settings-value i {
        color: #3b82f6;
        margin-left: 0.5rem;
    }
    .settings-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-cancel {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
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
        .settings-card {
            padding: 1.5rem;
        }
        .settings-actions {
            flex-direction: column;
        }
    }
</style>
@endsection
@section('main')
<div class="page-container" dir="rtl">
    <h2 class="page-header">الإعدادات</h2>

    @if (Session::has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="settings-card">
        <div class="settings-card-header">
            <h3 class="settings-card-title">
                <i class="fas fa-cog"></i>
                إعدادات التوصيل
            </h3>
            <button type="button" class="btn-edit-mode" onclick="toggleEditMode()">
                <i class="fas fa-edit"></i>
                تعديل الإعدادات
            </button>
        </div>

        <!-- View Mode -->
        <div id="viewMode">
            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-truck"></i>
                    سعر التوصيل لكل كيلومتر
                </label>
                <div class="settings-value">
                    <i class="fas fa-money-bill-wave"></i>
                    {{ $data['delivery_price_per_km'] ?? '0' }} جنيه
                </div>
            </div>
        </div>

        <!-- Edit Mode -->
        <form id="editMode" action="{{ route('super.settings.update') }}" method="POST" style="display: none;">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="deliveryPricePerKm" class="form-label">
                    <i class="fas fa-truck"></i>
                    سعر التوصيل لكل كيلومتر
                </label>
                <input type="number" 
                       step="0.01" 
                       class="form-control" 
                       id="deliveryPricePerKm" 
                       name="delivery_price_per_km" 
                       value="{{ $data['delivery_price_per_km'] ?? '' }}" 
                       required>
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    أدخل سعر التوصيل لكل كيلومتر بالعملة المحلية
                </div>
            </div>
            <div class="settings-actions">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save me-2"></i>
                    حفظ الإعدادات
                </button>
                <button type="button" class="btn btn-cancel" onclick="toggleEditMode()">
                    <i class="fas fa-times me-2"></i>
                    إلغاء
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleEditMode() {
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');
        const editButton = document.querySelector('.btn-edit-mode');
        
        if (viewMode.style.display !== 'none') {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
            editButton.innerHTML = '<i class="fas fa-eye"></i> عرض الإعدادات';
        } else {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            editButton.innerHTML = '<i class="fas fa-edit"></i> تعديل الإعدادات';
        }
    }
</script>
@endsection
