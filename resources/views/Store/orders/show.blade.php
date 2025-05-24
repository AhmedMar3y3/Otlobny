@extends('Store.layout')

@section('styles')
    <style>
        body, .container {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
        }
        .order-header {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        .card {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
            margin-bottom: 2rem;
            border: none;
        }
        .card-header {
            background: none;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            /* align-items: center; */
            gap: 0.5rem;
        }
        .card-body {
            color: #fff;
        }
        .section-divider {
            border: none;
            border-top: 2px solid rgba(255,255,255,0.08);
            margin: 2rem 0 2rem 0;
        }
        .image-upload-square {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 120px;
            height: 120px;
            border-radius: 15px;
            background: #222b3a;
            border: 2px solid #334155;
            margin: 0 auto;
        }
        .image-upload-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 15px;
        }
        .image-upload-square:hover {
            box-shadow: 0 0 0 3px #64748b;
        }
        .order-label {
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
        }
        .order-value {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .order-status {
            padding: 0.3rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            background: #334155;
            color: #38bdf8;
            display: inline-block;
        }
        .no-delegate {
            color: #ff6b6b;
            background: rgba(255,107,107,0.08);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
        }
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            margin: 1rem 0;
            position: relative;
            background: #1a2234;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(15,23,42,0.2) 0%, rgba(30,41,59,0.2) 100%);
            pointer-events: none;
            z-index: 1;
        }
        
        #orderMap {
            height: 400px;
            width: 100%;
            border-radius: 15px;
            z-index: 0;
        }
        
        .map-controls {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 2;
            display: flex;
            gap: 0.5rem;
        }
        
        .map-control-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .map-control-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .map-control-btn:active {
            transform: translateY(0);
        }
        
        .map-marker {
            background: #38bdf8;
            border: 2px solid #fff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            position: relative;
        }
        
        .map-marker::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid #38bdf8;
        }
        
        .map-popup {
            background: #1E293B;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1rem;
            color: #fff;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .map-popup .leaflet-popup-content-wrapper {
            background: #1E293B;
            border-radius: 12px;
            padding: 0;
        }
        
        .map-popup .leaflet-popup-content {
            margin: 0;
            padding: 1rem;
            color: #fff;
        }
        
        .map-popup .leaflet-popup-tip {
            background: #1E293B;
        }
        .back-btn {
            background: linear-gradient(135deg, #334155 0%, #0F172A 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 2rem;
            font-weight: 500;
            margin-bottom: 2rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(15,23,42,0.10);
        }
        .back-btn:hover {
            background: linear-gradient(135deg, #0F172A 0%, #334155 100%);
            color: #38bdf8;
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .order-header { font-size: 1.3rem; }
            .card-header { font-size: 1rem; }
            .image-upload-square { width: 80px; height: 80px; }
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('main')
    <div class="container text-end" style="direction: rtl;">
        <a href="{{ route('store.orders.index') }}" class="back-btn"><i class="fa fa-arrow-right ms-2"></i>العودة للطلبات</a>
        <div class="order-header">تفاصيل الطلب <span style="color:#38bdf8;">#{{ $order->id }}</span></div>

        <div class="card">
            <div class="card-header">
                <i class="fa fa-shop" title="تفاصيل الطلب"></i>
                {{ __('admin.order_details') }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 order-label">{{ __('admin.order_creation_date') }}</div>
                    <div class="col-6 order-value">{{ $order->created_at->format('Y-m-d g:i A') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 order-label">{{ __('admin.order_num') }}</div>
                    <div class="col-6 order-value">{{ $order->order_num }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 order-label">{{ __('admin.order_status') }}</div>
                    <div class="col-6 order-value"><span class="order-status">{{ __('order.' . $order->status->name)}}</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 order-label">{{ __('admin.products_price') }}</div>
                    <div class="col-6 order-value" dir="rtl">{{ $order->price }} {{ __('admin.rs') }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fa fa-seedling" title="تفاصيل المنتجات"></i>
                {{ __('admin.products_details') }}
            </div>
            <div class="card-body">
                @foreach ($order->items as $item)
                    <div class="card mb-3" style="background:rgba(255,255,255,0.01); box-shadow:none;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-12 mb-2 mb-md-0">
                                    <div class="image-upload-square border">
                                        <img src="{{ $item->product->image }}" alt="صورة المنتج" />
                                    </div>
                                </div>
                                <div class="col-md-9 col-12">
                                    <div class="row mb-2">
                                        <div class="col-6 order-label">{{ __('admin.product_name') }}</div>
                                        <div class="col-6 order-value">{{ $item->product->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 order-label">{{ __('admin.product_price') }}</div>
                                        <div class="col-6 order-value" dir="rtl">{{ $item->product_price }} {{ __('admin.rs') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 order-label">{{ __('admin.product_quantity') }}</div>
                                        <div class="col-6 order-value">{{ $item->quantity }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 order-label">{{ __('admin.total_price') }}</div>
                                        <div class="col-6 order-value" dir="rtl">{{ $item->total_price }} {{ __('admin.rs') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fa fa-user" title="تفاصيل المندوب"></i>
                {{ __('admin.delegate_details') }}
            </div>
            <div class="card-body">
                @if ($order->delegate)
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 col-12 mb-2 mb-md-0">
                            <div class="image-upload-square border">
                                <img src="{{ $order->delegate->image }}" alt="صورة المندوب" />
                            </div>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="row mb-2">
                                <div class="col-6 order-label">{{ __('admin.delegate_name') }}</div>
                                <div class="col-6 order-value">{{ $order->delegate->first_name }} {{ $order->delegate->last_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 order-label">{{ __('admin.delegate_phone') }}</div>
                                <div class="col-6 order-value">{{ $order->delegate->phone }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="no-delegate">
                        <i class="fa fa-user-times fa-2x mb-2"></i><br>
                        {{ __('admin.no_delegate') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection