@extends('layout')

@section('styles')
    <style>
        hr {
            margin: 0;
        }

        .image-upload-square {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 250px; 
            height: 250px;
            border-radius: 15px;
        }

        .image-upload-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .image-upload-square:hover {
            background-color: #9fa0a0;
        }

    </style>
@endsection

@section('main')
<div class="container text-end">
    <h1>تفاصيل الطلب #{{ $order->id }}</h1>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="">{{ __('admin.order_details') }} <i class="fa fa-shop"></i></h5>
                </div>
                <hr>
    
                <div class="card-content">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-4">{{ $order->created_at->format('Y-m-d g:i A') }}</div>
                            <div class="col-8">{{ __('admin.order_creation_date') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">{{ $order->order_num }}</div>
                            <div class="col-8">{{ __('admin.order_num') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">{{ __('order.'.$order->status->name)}}</div>
                            <div class="col-8">{{ __('admin.order_status') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4" dir="rtl"> {{ $order->price }} {{ __('admin.rs') }}</div>
                            <div class="col-8">{{ __('admin.products_price') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4" dir="rtl">{{  $order->delivery_price}} {{ __('admin.rs') }}</div>
                            <div class="col-8">{{ __('admin.delivery_price') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4" dir="rtl">{{ $order->total_price}} {{ __('admin.rs') }}</div>
                            <div class="col-8">{{ __('admin.total_price') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">{{ __('order.'.$order->pay_type->name) }}</div>
                            <div class="col-8">{{ __('admin.pay_type') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">{{ __('order.'.$order->pay_status->name) }}</div>
                            <div class="col-8">{{ __('admin.pay_status') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h5 class="">{{ __('admin.products_details') }} <i class="fa fa-seedling"></i></h5>
                </div>
                <hr>
            
                <div class="card-content">
                    <div class="card-body">
                        @foreach ($order->items as $item)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                                <div id="imageContainer" class="image-upload-square border">
                                                    <img id="previewImage" src="{{ $item->product->image }}" 
                                                         alt="Image Preview" 
                                                         style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row mb-1">
                                                <div class="col-6">{{ $item->product->name }}</div>
                                                <div class="col-6">{{ __('admin.product_name') }}</div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-6" dir="rtl">{{ $item->product_price }} {{ __('admin.rs') }}</div>
                                                <div class="col-6">{{ __('admin.product_price') }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6">{{ $item->quantity }}</div>
                                                <div class="col-6">{{ __('admin.product_quantity') }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6">{{ $item->free_quantity }}</div>
                                                <div class="col-6">{{ __('admin.product_free_quantity') }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6" dir="rtl">{{ $item->total_price }} {{ __('admin.rs') }}</div>
                                                <div class="col-6">{{ __('admin.total_price') }}</div>
                                            </div>
                                            <hr>
                                            <div class="mt-2">
                                                <h3>{{ __('admin.additions') }}</h3>
                                            </div>
                                            @forelse ($item->additions as $addtion)
                                                <div class="row mb-1">
                                                    <div class="col-6" dir="rtl">{{ $addtion->price }} {{ __('admin.rs') }}</div>
                                                    <div class="col-6">{{ $addtion->name }}</div>
                                                </div>
                                            @empty
                                                <h4> {{  __('admin.no_additions')}} </h4>
                                            @endforelse
                                            @if ($item->additions->isNotEmpty())
                                                <div class="row mb-1">
                                                    <div class="col-6" dir="rtl">{{ $item->additions->sum('price') }} {{ __('admin.rs') }}</div>
                                                    <div class="col-6">{{ __('admin.total_additions_price') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h5 class="">{{ __('admin.user_details') }} <i class="fa fa-user"></i></h5>
                </div>
                <hr>
                @if ($order->user)

                <div class="card-content">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div id="imageContainer" class="image-upload-square border">
                                <img id="previewImage" src="{{ $order->user->image }}" 
                                        alt="Image Preview" 
                                        style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-4">{{ $order->user->first_name }} {{ $order->user->last_name }}</div>
                            <div class="col-8">{{ __('admin.user_name') }}</div>
                        </div>

                        <div class="row mb-1">
                            <div class="col-4">{{ $order->user->phone }}</div>
                            <div class="col-8">{{ __('admin.user_phone') }}</div>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center p-4">
                    <h4>{{ __('admin.unknown_or_deleted') }}</h4>
                </div>
                @endif
            </div>

            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h5 class="">{{ __('admin.delegate_details') }} <i class="fa fa-user"></i></h5>
                </div>
                <hr>
                @if ($order->delegate)
                    <div class="card-content">
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-center align-items-center">
                                <div id="imageContainer" class="image-upload-square border">
                                    <img id="previewImage" src="{{ $order->delegate->image }}" 
                                            alt="Image Preview" 
                                            style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">{{ $order->delegate->first_name }} {{ $order->delegate->last_name }}</div>
                                <div class="col-8">{{ __('admin.delegate_name') }}</div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-4">{{ $order->delegate->phone }}</div>
                                <div class="col-8">{{ __('admin.delegate_phone') }}</div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="text-center p-4">
                    <h4>{{ __('admin.no_delegate') }}</h4>
                </div>
                @endif
            </div>


            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h5 class="">{{ __('admin.delivery_location') }} <i class="fa fa-map"></i></h5>
                </div>
                <hr>

                <div class="card-content">
                    <div class="card-body">
                        <div id="orderMap" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    // Initialize map
    var map = L.map('orderMap').setView([{{ $order->lat }}, {{ $order->lng }}], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add marker
    L.marker([{{ $order->lat }}, {{ $order->lng }}])
     .addTo(map)
     .bindPopup('{{ $order->map_desc }}')
     .openPopup();
</script>
@endsection