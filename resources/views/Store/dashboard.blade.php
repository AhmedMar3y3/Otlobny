@extends('Store.layout')
@section('main')
<div class="row" dir="rtl">
    <!-- Welcome Section -->
    <div class="col-12 mb-4">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-white mb-2">مرحباً، {{ Auth::guard('store')->user()->name }}</h2>
                    <p class="text-white-50 mb-0">نتمنى لك يوماً سعيداً في إدارة متجرك</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-success p-2">
                        <i class="fa fa-circle me-1"></i> متصل
                    </span>
                    <form action="{{ route('store.toggleOpenClose') }}" method="POST" class="mt-3">
                        @csrf
                        @php $isOpen = Auth::guard('store')->user()->is_open; @endphp
                        <button type="submit" class="btn btn-toggle-open-close {{ $isOpen ? 'btn-danger' : 'btn-success' }} w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa {{ $isOpen ? 'fa-door-closed' : 'fa-door-open' }}"></i>
                            <span>{{ $isOpen ? 'إغلاق المتجر' : 'فتح المتجر' }}</span>
                        </button>
                        <div class="mt-2">
                            <span class="badge {{ $isOpen ? 'bg-success' : 'bg-danger' }}">
                                <i class="fa {{ $isOpen ? 'fa-check' : 'fa-times' }} me-1"></i>
                                {{ $isOpen ? 'المتجر مفتوح' : 'المتجر مغلق' }}
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-sm-4 grid-margin">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none; transition: transform 0.3s ease;">
            <div class="card-body">
                <h3 class="text-white mb-3">{{ __('admin.categories') }}</h3>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0 text-white">{{ $categories }}</h2>
                        </div>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg fa fa-tags text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none; transition: transform 0.3s ease;">
            <div class="card-body">
                <h3 class="text-white mb-3">{{ __('admin.products') }}</h3>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0 text-white">{{ $products }}</h2>
                        </div>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg fa fa-cubes text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 grid-margin">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none; transition: transform 0.3s ease;">
            <div class="card-body">
                <h3 class="text-white mb-3">{{ __('admin.orders') }}</h3>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0 text-white">{{ $orders }}</h2>
                        </div>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg fa fa-shopping-cart text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="col-12 mb-4">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-white">{{ __('admin.new_orders') }}</h3>
                    <span class="badge bg-primary p-2">{{ __('admin.last_week') }}</span>
                </div>
                <div id="newOrdersChart"></div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-md-6 mb-4">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none;">
            <div class="card-body">
                <h3 class="text-white mb-4">إجراءات سريعة</h3>
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('store.products.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa fa-plus"></i>
                            <span>إضافة منتج</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('store.categories.index') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa fa-tags"></i>
                            <span>إدارة الفئات</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('store.orders.index') }}" class="btn btn-warning w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa fa-shopping-cart"></i>
                            <span>الطلبات</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('store.profile.index') }}" class="btn btn-info w-100 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa fa-user"></i>
                            <span>الملف الشخصي</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-md-6 mb-4">
        <div class="card shadow" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border: none;">
            <div class="card-body">
                <h3 class="text-white mb-4">آخر الطلبات</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                        {{ __('order.'.$order->status->name) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('store.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">لا توجد طلبات حديثة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 32px rgba(15,23,42,0.30);
}
.table-dark {
    background-color: transparent;
}
.table-dark thead th {
    border-bottom: 2px solid rgba(255,255,255,0.1);
}
.table-dark td, .table-dark th {
    border-color: rgba(255,255,255,0.1);
}
.btn-toggle-open-close {
    border-radius: 10px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    transition: all 0.3s;
    border: none;
    margin-top: 0.5rem;
}
.btn-toggle-open-close.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #fff;
}
.btn-toggle-open-close.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
}
.btn-toggle-open-close:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16,185,129,0.2);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const last7Days = @json(array_keys($last7DaysOrders->toArray()));
    const dailyOrders = @json(array_values($last7DaysOrders->toArray()));

    new ApexCharts(document.querySelector("#newOrdersChart"), {
        series: [{ 
            name: 'New Orders', 
            data: dailyOrders 
        }],
        chart: { 
            height: 350, 
            type: 'area', 
            toolbar: { show: false },
            fontFamily: 'inherit',
            background: 'transparent'
        },
        markers: { 
            size: 4,
            colors: ['#4361ee'],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: {
                size: 6
            }
        },
        colors: ['#4361ee'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90, 100]
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        xaxis: {
            categories: last7Days,
            labels: {
                style: {
                    colors: '#fff'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#fff'
                }
            }
        },
        grid: {
            borderColor: 'rgba(255,255,255,0.1)',
            strokeDashArray: 4,
            xaxis: {
                lines: {
                    show: true
                }
            }
        },
        tooltip: {
            theme: 'dark',
            x: { format: 'dd/MM/yy' },
            style: {
                fontSize: '12px',
                fontFamily: 'inherit'
            }
        }
    }).render();
});
</script>
@endsection
