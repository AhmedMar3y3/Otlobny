@extends('Admin.layout')

@section('main')
<div class="container text-end">
    <h2>الإعدادات</h2>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Delivery Price Setting -->
        <div class="mb-3">
            <label for="delivery_price_per_km" class="form-label text-end" style="color: black">{{ __('admin.delivery_price') }}</label>
            <input type="number" name="delivery_price_per_km" class="form-control text-end" id="delivery_price_per_km" 
                   value="{{ $data['delivery_price_per_km'] ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection
