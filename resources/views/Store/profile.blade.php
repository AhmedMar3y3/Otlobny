@extends('Store.layout')

@section('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .profile-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .profile-header h2 {
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
    
    .card-header {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #fff;
        font-size: 1.2rem;
        font-weight: 500;
        padding: 1.2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .card-body {
        padding: 2rem;
        color: #fff;
    }
    
    .form-label {
        color: #fff !important;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.8rem;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        box-shadow: none;
    }
    
    .form-control::placeholder {
        color: rgba(255,255,255,0.5);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(15,23,42,0.30);
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    #map {
        height: 400px;
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    }
    
    .location-button {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .location-button:hover {
        color: rgba(255,255,255,0.8);
        text-decoration: underline;
    }
    
    .location-error {
        color: #ff6b6b;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        border-radius: 5px;
        background-color: rgba(255,107,107,0.1);
    }
    
    .profile-image-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 1rem 0;
        border: 3px solid rgba(255,255,255,0.2);
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .text-danger {
        color: #ff6b6b !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endsection

@section('main')
<div class="profile-container" style="direction: rtl;">
    <div class="profile-header">
        <h2>الملف الشخصي</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Profile Update Form -->
    <div class="card">
        <div class="card-header">تحديث الملف الشخصي</div>
        <div class="card-body">
            <form action="{{ route('store.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="whatsapp" class="form-label">رقم الواتساب</label>
                    <input type="text" name="whatsapp" class="form-control" id="whatsapp" value="{{ $user->whatsapp }}">
                    <small class="form-text text-muted">يرجى إدخال رقم الهاتف بصيغة دولية (مثال: +201234567890)</small>
                    @error('whatsapp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image" class="form-label">الصورة</label>
                    @if ($user->image)
                        <img src="{{ asset($user->image) }}" alt="" class="profile-image-preview">
                    @endif
                    <input type="file" name="image" class="form-control" id="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div class="form-group">
                    <label for="category_id" class="form-label">الفئة</label>
                    <select name="category_id" class="form-select" id="category_id">
                        <option value="">اختر فئة</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $user->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Delivery Time Min -->
                <div class="form-group">
                    <label for="delivery_time_min" class="form-label">أقل وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_min" class="form-control" id="delivery_time_min" value="{{ $user->delivery_time_min }}">
                    @error('delivery_time_min')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Delivery Time Max -->
                <div class="form-group">
                    <label for="delivery_time_max" class="form-label">أقصى وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_max" class="form-control" id="delivery_time_max" value="{{ $user->delivery_time_max }}">
                    @error('delivery_time_max')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location Selection -->
                <div class="form-group">
                    <label class="form-label">الموقع</label>
                    <p>انقر على الخريطة لتحديد موقعك أو <span class="location-button" id="use-device-location">استخدام موقع جهازك الحالي</span></p>
                    <div id="map"></div>
                    <div id="location-error" class="location-error" style="display: none;"></div>
                    <input type="hidden" name="lng" id="lng" value="{{ $user->lng ?? '' }}">
                    <input type="hidden" name="lat" id="lat" value="{{ $user->lat ?? '' }}">
                    @error('lng')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('lat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">تحديث الملف الشخصي</button>
            </form>
        </div>
    </div>

    <!-- Password Change Form -->
    <div class="card">
        <div class="card-header">تغيير كلمة المرور</div>
        <div class="card-body">
            <form action="{{ route('store.profile.password') }}" method="POST">
                @csrf

                <!-- Current Password -->
                <div class="form-group">
                    <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="form-control" id="current_password">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control" id="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>

                <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
            </form>
        </div>
    </div>
</div>

<!-- Leaflet JavaScript and Initialization Script -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLocation = [31.2001, 29.9187]; // Fallback to Alexandria, Egypt
    const userLat = {{ $user->lat ?? 'null' }};
    const userLng = {{ $user->lng ?? 'null' }};
    const hasLocation = userLat !== null && userLng !== null;
    const userLocation = hasLocation ? [userLat, userLng] : null;

    let map, marker;

    function initializeMap(center) {
        map = L.map('map').setView(center, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        if (hasLocation) {
            marker = L.marker(userLocation, { draggable: true }).addTo(map);
            marker.on('dragend', function(e) {
                updateLocation(marker.getLatLng());
            });
        }

        map.on('click', function(e) {
            if (!marker) {
                marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    updateLocation(marker.getLatLng());
                });
            } else {
                marker.setLatLng(e.latlng);
            }
            updateLocation(e.latlng);
        });

        map.on('tileerror', function() {
            document.getElementById('map').innerHTML = '<p class="text-danger">خطأ في تحميل الخريطة. يرجى التحقق من اتصال الإنترنت.</p>';
        });
    }

    function updateLocation(latlng) {
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;
    }

    function requestDeviceLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const deviceLocation = [position.coords.latitude, position.coords.longitude];
                    map.setView(deviceLocation, 12);
                    if (marker) {
                        marker.setLatLng(deviceLocation);
                    } else {
                        marker = L.marker(deviceLocation, { draggable: true }).addTo(map);
                        marker.on('dragend', function(e) {
                            updateLocation(marker.getLatLng());
                        });
                    }
                    updateLocation({ lat: deviceLocation[0], lng: deviceLocation[1] });
                    document.getElementById('location-error').style.display = 'none';
                },
                function(error) {
                    let errorMessage = '';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'تم رفض الوصول إلى الموقع. يرجى السماح بالوصول في إعدادات المتصفح أو تحديد الموقع يدويًا.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'معلومات الموقع غير متوفرة. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'انتهت مهلة طلب الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                        default:
                            errorMessage = 'حدث خطأ أثناء جلب الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                    }
                    document.getElementById('location-error').innerText = errorMessage;
                    document.getElementById('location-error').style.display = 'block';
                },
                {
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        } else {
            document.getElementById('location-error').innerText = 'المتصفح لا يدعم تحديد الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
            document.getElementById('location-error').style.display = 'block';
        }
    }

    const center = userLocation || defaultLocation;
    initializeMap(center);

    if (!hasLocation && navigator.permissions && navigator.permissions.query) {
        navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
            if (result.state === 'granted') {
                requestDeviceLocation();
            } else if (result.state === 'prompt') {
                document.getElementById('location-error').innerText = 'لم يتم تحديد موقعك. انقر على "استخدام موقع جهازك الحالي" للسماح بالوصول.';
                document.getElementById('location-error').style.display = 'block';
            } else if (result.state === 'denied') {
                document.getElementById('location-error').innerText = 'تم رفض الوصول إلى الموقع. يرجى السماح بالوصول في إعدادات المتصفح أو تحديد الموقع يدويًا.';
                document.getElementById('location-error').style.display = 'block';
            }
        }).catch(function() {
            document.getElementById('location-error').innerText = 'تعذر التحقق من إعدادات الموقع. يرجى تحديد الموقع يدويًا أو استخدام زر تحديد الموقع.';
            document.getElementById('location-error').style.display = 'block';
        });
    } else if (!hasLocation) {
        document.getElementById('location-error').innerText = 'لم يتم تحديد موقعك. انقر على "استخدام موقع جهازك الحالي" للسماح بالوصول.';
        document.getElementById('location-error').style.display = 'block';
    }

    document.getElementById('use-device-location').addEventListener('click', function() {
        requestDeviceLocation();
    });
});
</script>
@endsection