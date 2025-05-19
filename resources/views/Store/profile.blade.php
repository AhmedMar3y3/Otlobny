@extends('Store.layout')

@section('styles')
<style>
    #map {
        height: 400px;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .location-error {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
    }
    .location-button {
        margin-top: 10px;
        cursor: pointer;
        color: #007bff;
        text-decoration: underline;
    }
    .location-button:hover {
        color: #0056b3;
    }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endsection

@section('main')
<div class="container" style="direction: rtl;">
    <h2>الملف الشخصي</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Profile Update Form -->
    <div class="card mb-4">
        <div class="card-header">تحديث الملف الشخصي</div>
        <div class="card-body">
            <form action="{{ route('store.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">الصورة</label>
                    @if ($user->image)
                        <img src="{{ asset($user->image) }}" alt="" style="width: 40px; height: 40px;">
                    @endif
                    <input type="file" name="image" class="form-control" id="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div class="mb-3">
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
                <div class="mb-3">
                    <label for="delivery_time_min" class="form-label">أقل وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_min" class="form-control" id="delivery_time_min" value="{{ $user->delivery_time_min }}">
                    @error('delivery_time_min')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Delivery Time Max -->
                <div class="mb-3">
                    <label for="delivery_time_max" class="form-label">أقصى وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_max" class="form-control" id="delivery_time_max" value="{{ $user->delivery_time_max }}">
                    @error('delivery_time_max')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location Selection -->
                <div class="mb-3">
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
                <div class="mb-3">
                    <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="form-control" id="current_password">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control" id="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div class="mb-3">
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