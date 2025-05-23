@extends('Store.layout')
@section('main')
<div class="row" dir="rtl">
  <div class="col-sm-4 grid-margin">
    <div class="card shadow" style="background-color: #0F172A; box-shadow: 0 8px 32px rgba(15,23,42,0.30);">
      <div class="card-body">
        <h3>{{ __('admin.categories') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $categories }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-tags" style="color: #fff;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card shadow" style="background-color: #0F172A; box-shadow: 0 8px 32px rgba(15,23,42,0.30);">
      <div class="card-body">
        <h3>{{ __('admin.products') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $products }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-cubes" style="color: #fff;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card shadow" style="background-color: #0F172A; box-shadow: 0 8px 128px rgba(15,23,42,0.30);">
      <div class="card-body">
        <h3>{{ __('admin.orders') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $orders }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-shopping-cart" style="color: #fff;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>


    <!-- Chart Section -->
    <div class="col-12">
    <div class="card shadow" style="background-color: #0F172A; box-shadow: 0 8px 128px rgba(15,23,42,0.30);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title mb-0">{{ __('admin.new_orders') }}</h3>
                    <span class="badge bg-primary">{{ __('admin.last_week') }}</span>
                </div>
                <div id="newOrdersChart"></div>
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
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.7,
                                    opacityTo: 0.3,
                                    stops: [0, 90, 100]
                                }
                            },
                            dataLabels: { enabled: false },
                            stroke: { 
                                curve: 'smooth', 
                                width: 3 
                            },
                            xaxis: { 
                                type: 'datetime', 
                                categories: last7Days,
                                labels: {
                                    style: {
                                        colors: '#666',
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function (val) { 
                                        return Math.round(val) + " طلبات"; 
                                    },
                                    style: {
                                        colors: '#666',
                                        fontSize: '12px'
                                    }
                                },
                                min: 0,
                                forceNiceScale: true
                            },
                            grid: {
                                borderColor: '#f1f1f1',
                                strokeDashArray: 4,
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                }
                            },
                            tooltip: {
                                x: { format: 'dd/MM/yy' },
                                theme: 'light',
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'inherit'
                                }
                            }
                        }).render();
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
