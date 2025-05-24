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
    .card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .card-header {
        background: rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.1);
        color: #fff;
        font-weight: 600;
        font-size: 1.25rem;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .card-header i {
        color: #3b82f6;
    }
    .card-body {
        padding: 1.5rem;
    }
    .list-group {
        background: transparent;
    }
    .list-group-item {
        background: transparent;
        border-color: rgba(255,255,255,0.1);
        color: #fff;
        padding: 1rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .list-group-item i {
        color: #3b82f6;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }
    .info-label {
        color: #94a3b8;
        font-weight: 500;
        min-width: 150px;
    }
    .info-value {
        color: #fff;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    .stat-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    .stat-item:hover {
        transform: translateY(-2px);
        background: rgba(255,255,255,0.08);
    }
    .stat-value {
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #94a3b8;
        font-size: 0.875rem;
    }
    .stat-item i {
        color: #3b82f6;
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }
    #map {
        height: 400px;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    .leaflet-container {
        background: #1E293B !important;
    }
    .leaflet-control-zoom {
        border: none !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25) !important;
    }
    .leaflet-control-zoom a {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%) !important;
        color: #fff !important;
        border: none !important;
    }
    .leaflet-control-zoom a:hover {
        background: rgba(255,255,255,0.1) !important;
    }
    .leaflet-popup-content-wrapper {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%) !important;
        color: #fff !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25) !important;
    }
    .leaflet-popup-tip {
        background: #1E293B !important;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .status-active {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    .status-inactive {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .rating-stars i {
        color: #f59e0b;
    }
    .rating-value {
        color: #fff;
        font-weight: 600;
    }
    .rating-count {
        color: #94a3b8;
        font-size: 0.875rem;
    }
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem 0;
        }
        .page-header {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .card-header {
            font-size: 1.1rem;
            padding: 1rem;
        }
        .card-body {
            padding: 1rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .info-label {
            min-width: auto;
        }
    }
</style>
@endsection

@section('main')
<div class="page-container" dir="rtl">
    <h2 class="page-header">تفاصيل المتجر</h2>

    <!-- Store Details -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-store"></i>
            معلومات المتجر
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <i class="fas fa-tag"></i>
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $store->name }}</span>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-envelope"></i>
                    <span class="info-label">البريد الإلكتروني:</span>
                    <span class="info-value">{{ $store->email }}</span>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-star"></i>
                    <span class="info-label">التقييم:</span>
                    <div class="rating-stars">
                        <div class="rating-value">{{ $store->rating }}</div>
                        <div class="rating-count">({{ $store->number_of_ratings }} تقييم)</div>
                    </div>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-clock"></i>
                    <span class="info-label">وقت التوصيل:</span>
                    <span class="info-value">{{ $store->delivery_time_min }} - {{ $store->delivery_time_max }} دقيقة</span>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-tags"></i>
                    <span class="info-label">الفئة:</span>
                    <span class="info-value">{{ $store->category->name ?? 'غير محدد' }}</span>
                </li>
                <li class="list-group-item">
                    <i class="fas fa-toggle-on"></i>
                    <span class="info-label">الحالة:</span>
                    <span class="status-badge {{ $store->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas {{ $store->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $store->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chart-bar"></i>
            معلومات إضافية
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-item">
                    <i class="fas fa-box"></i>
                    <div class="stat-value">{{ $store->products->count() }}</div>
                    <div class="stat-label">عدد المنتجات</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-tags"></i>
                    <div class="stat-value">{{ $store->productCategories->count() }}</div>
                    <div class="stat-label">عدد الفئات</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Map -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-map-marker-alt"></i>
            الموقع
        </div>
        <div class="card-body">
            @if ($store->lat && $store->lng)
                <div id="map"></div>
            @else
                <div class="text-center text-muted">
                    <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
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
                    const map = L.map('map').setView([{{ $store->lat }}, {{ $store->lng }}], 12);
                    
                    // Add custom tile layer with dark theme
                    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(map);

                    // Add custom marker
                    const marker = L.marker([{{ $store->lat }}, {{ $store->lng }}]).addTo(map);
                    
                    // Add custom popup
                    marker.bindPopup(`
                        <div style="text-align: center;">
                            <strong style="color: #fff;">{{ $store->name }}</strong>
                            <br>
                            <small style="color: #94a3b8;">موقع المتجر</small>
                        </div>
                    `);

                    // Add custom zoom control
                    const zoomControl = L.control.zoom({
                        position: 'bottomright'
                    }).addTo(map);

                    console.log('Map initialized successfully');
                } catch (error) {
                    console.error('Map initialization failed:', error);
                    document.getElementById('map').innerHTML = `
                        <div class="text-center text-danger p-4">
                            <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                            <p>خطأ في تحميل الخريطة. يرجى التحقق من اتصال الإنترنت أو إعدادات المتصفح.</p>
                        </div>
                    `;
                }
            });
        </script>
    @endpush
@endif
@endsection