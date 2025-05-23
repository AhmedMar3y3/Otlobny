@extends('Super.layout')
@section('main')
<div class="row" dir="rtl">
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.users') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $users }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-users text-primary ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.admins') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $admins }}</h2>
            </div>
          </div>
            <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-user-shield" style="color: purple; margin-left: auto;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.code') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $code }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-key" style="color: grey; margin-left: auto;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.delegates') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $delegates }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-motorcycle text-success ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.stores') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $stores }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-store text-info ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3 style="color: black">{{ __('admin.orders') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0" style="color: black">{{ $orders }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-shopping-cart text-warning ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Chart Section -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title mb-0">{{ __('admin.new_users') }}</h3>
                    <span class="badge bg-primary">{{ __('admin.last_week') }}</span>
                </div>
                <div id="newUsersChart"></div>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const last7Days = @json(array_keys($last7DaysUsers->toArray()));
                        const dailyUsers = @json(array_values($last7DaysUsers->toArray()));

                        new ApexCharts(document.querySelector("#newUsersChart"), {
                            series: [{ 
                                name: 'New Users', 
                                data: dailyUsers 
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
                                        return Math.round(val) + " مستخدم"; 
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
