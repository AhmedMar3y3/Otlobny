@extends('Admin.layout')

@section('styles')
<style>
    #map {
        height: 400px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
@endsection

@section('main')
<div class="container text-end">
    <h2>تفاصيل المتجر</h2>

    <!-- Store Details -->
    <div class="card">
        <div class="card-header">معلومات المتجر</div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">الاسم: {{ $store->name }}</li>
                <li class="list-group-item">البريد الإلكتروني: {{ $store->email }}</li>
                <li class="list-group-item">التقييم: {{ $store->rating }}</li>
                <li class="list-group-item">عدد التقييمات: {{ $store->number_of_ratings }}</li>
                <li class="list-group-item">أقل وقت للتوصيل: {{ $store->delivery_time_min }}</li>
                <li class="list-group-item">أقصى وقت للتوصيل: {{ $store->delivery_time_max }}</li>
                <li class="list-group-item">الفئة: {{ $store->category->name ?? 'غير محدد' }}</li>
                <li class="list-group-item">نشط: {{ $store->is_active ? 'نعم' : 'لا' }}</li>
            </ul>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="card mt-4">
        <div class="card-header">معلومات إضافية</div>
        <div class="card-body">
            <p>عدد المنتجات: {{ $store->products->count() }}</p>
            <p>عدد الفئات: {{ $store->productCategories->count() }}</p>
        </div>
    </div>

    <!-- Location Map -->
    <div class="card mt-4">
        <div class="card-header">الموقع</div>
        <div class="card-body">
            @if ($store->lat && $store->lng)
                <div id="map"></div>
            @else
                <p>الموقع غير متاح.</p>
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
                    console.log('Initializing map with lat: {{ $store->lat }}, lng: {{ $store->lng }}');
                    const map = L.map('map').setView([{{ $store->lat }}, {{ $store->lng }}], 12);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(map);
                    L.marker([{{ $store->lat }}, {{ $store->lng }}]).addTo(map);
                    console.log('Map initialized successfully');
                } catch (error) {
                    console.error('Map initialization failed:', error);
                    document.getElementById('map').innerHTML = '<p class="text-danger">خطأ في تحميل الخريطة. يرجى التحقق من اتصال الإنترنت أو إعدادات المتصفح.</p>';
                }
            });
        </script>
    @endpush
@endif
@endsection