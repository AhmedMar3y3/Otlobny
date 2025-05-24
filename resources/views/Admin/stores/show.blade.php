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
    
    .store-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: none;
    }
    
    .card-header {
        background: rgba(255,255,255,0.05);
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px 12px 0 0;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        color: #fff;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        color: #94a3b8;
        font-weight: 500;
    }
    
    .info-value {
        color: #fff;
        font-weight: 600;
    }
    
    .rating-badge {
        background: rgba(255,193,7,0.1);
        color: #ffc107;
        padding: 0.3rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-badge {
        padding: 0.3rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .status-active {
        background: rgba(16,185,129,0.1);
        color: #10b981;
    }
    
    .status-inactive {
        background: rgba(239,68,68,0.1);
        color: #ef4444;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .stat-item {
        background: rgba(255,255,255,0.05);
        padding: 1rem;
        border-radius: 8px;
        text-align: center;
    }
    
    .stat-value {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .map-container {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }
    
    #map {
        height: 400px;
        width: 100%;
        border-radius: 12px;
    }
    
    .back-button {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .back-button:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
        color: #fff;
    }
    
    .back-button i {
        margin-left: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .page-header { font-size: 1.5rem; }
        .stats-grid { grid-template-columns: 1fr; }
        .card-body { padding: 1rem; }
    }
</style>
@endsection

@section('main')
<div class="container text-end" style="direction: rtl;">
    <a href="{{ route('admin.stores.index') }}" class="back-button">
        <i class="fa fa-arrow-right"></i>
        العودة إلى قائمة المتاجر
    </a>
    
    <div class="page-header">تفاصيل المتجر</div>

    <!-- Store Details -->
    <div class="store-card">
        <div class="card-header">معلومات المتجر</div>
        <div class="card-body">
            <ul class="info-list">
                <li class="info-item">
                    <span class="info-label">الاسم</span>
                    <span class="info-value">{{ $store->name }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">البريد الإلكتروني</span>
                    <span class="info-value">{{ $store->email }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">التقييم</span>
                    <span class="rating-badge">
                        <i class="fa fa-star me-1"></i>
                        {{ $store->rating }}
                    </span>
                </li>
                <li class="info-item">
                    <span class="info-label">عدد التقييمات</span>
                    <span class="info-value">{{ $store->number_of_ratings }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">أقل وقت للتوصيل</span>
                    <span class="info-value">{{ $store->delivery_time_min }} دقيقة</span>
                </li>
                <li class="info-item">
                    <span class="info-label">أقصى وقت للتوصيل</span>
                    <span class="info-value">{{ $store->delivery_time_max }} دقيقة</span>
                </li>
                <li class="info-item">
                    <span class="info-label">الفئة</span>
                    <span class="info-value">{{ $store->category->name ?? 'غير محدد' }}</span>
                </li>
                <li class="info-item">
                    <span class="info-label">الحالة</span>
                    <span class="status-badge {{ $store->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $store->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="store-card">
        <div class="card-header">معلومات إضافية</div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">{{ $store->products->count() }}</div>
                    <div class="stat-label">عدد المنتجات</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $store->productCategories->count() }}</div>
                    <div class="stat-label">عدد الفئات</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Map -->
    <div class="store-card">
        <div class="card-header">الموقع</div>
        <div class="card-body">
            @if ($store->lat && $store->lng)
                <div class="map-container">
                    <div id="map"></div>
                </div>
            @else
                <div class="text-center text-muted">
                    <i class="fa fa-map-marker-alt fa-3x mb-3"></i>
                    <p>الموقع غير متاح.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Leaflet CSS and JS -->
@if ($store->lat && $store->lng)
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                try {
                    const map = L.map('map', {
                        zoomControl: false
                    }).setView([{{ $store->lat }}, {{ $store->lng }}], 12);
                    
                    // Add custom zoom control
                    L.control.zoom({
                        position: 'bottomright'
                    }).addTo(map);
                    
                    // Add custom tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(map);
                    
                    // Add custom marker
                    const marker = L.marker([{{ $store->lat }}, {{ $store->lng }}]).addTo(map);
                    
                    // Add popup with store name
                    marker.bindPopup('{{ $store->name }}').openPopup();
                    
                } catch (error) {
                    console.error('Map initialization failed:', error);
                    document.getElementById('map').innerHTML = `
                        <div class="text-center text-danger p-4">
                            <i class="fa fa-exclamation-circle fa-3x mb-3"></i>
                            <p>خطأ في تحميل الخريطة. يرجى التحقق من اتصال الإنترنت أو إعدادات المتصفح.</p>
                        </div>
                    `;
                }
            });
        </script>
    @endpush
@endif
@endsection