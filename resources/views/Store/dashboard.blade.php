@extends('Store.layout')
@section('main')
<div class="row" dir="rtl">
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3>{{ __('admin.categories') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $categories }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-tags text-primary ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3>{{ __('admin.products') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $products }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-cubes text-danger ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4 grid-margin">
    <div class="card">
      <div class="card-body">
        <h3>{{ __('admin.orders') }}</h3>
        <div class="row">
          <div class="col-8 col-sm-12 col-xl-8 my-auto">
            <div class="d-flex d-sm-block d-md-flex align-items-center">
              <h2 class="mb-0">{{ $orders }}</h2>
            </div>
          </div>
          <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
            <i class="icon-lg fa fa-shopping-cart text-warning ml-auto"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- New orders Chart Section -->
<div class="col-12">
  <div class="card rounded">
    <div class="card-body">
      <h3 class="card-title">{{ __('admin.new_orders') }}<span>{{ __('admin.last_week') }}</span></h3>
      <div id="newOrdersChart"></div>
      <script>
     document.addEventListener("DOMContentLoaded", () => {
    const last7Days = @json(array_keys($last7DaysOrders->toArray()));
    const dailyOrders = @json(array_values($last7DaysOrders->toArray()));

    new ApexCharts(document.querySelector("#newOrdersChart"), {
        series: [{ name: 'New Orders', data: dailyOrders }],
        chart: { height: 350, type: 'area', toolbar: { show: false } },
        markers: { size: 4 },
        colors: ['black'],
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.4,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: { type: 'datetime', categories: last7Days },
        yaxis: {
            labels: {
                formatter: function (val) { return Math.round(val) + " طلبات"; }
            },
            min: 0,
            forceNiceScale: true
        },
        tooltip: {
            x: { format: 'dd/MM/yy' },
            theme: 'dark',
            style: {
                fontSize: '12px',
                fontFamily: 'Arial, sans-serif',
                color: '#000000'
            }
        }
    }).render();
});

      </script>
    </div>
  </div>
</div>

@endsection
