@extends('layout')

@section('main')
<div class="container text-end">
    <h1>الطلبات</h1>
    
    @if (Session::has('success'))
    <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>الحالة</th>
                <th>المندوب</th>
                <th>طريقة الدفع</th>
                <th>السعر</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>
                    <div class="btn-group" role="group">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" 
                                    id="dropdownMenuButton-{{ $order->id }}" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                تعيين مندوب
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                <li>
                                    <form action="{{ route('admin.orders.assign', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="px-3 py-2">
                                            <select name="delegate_id" class="form-select" 
                                                    onchange="this.form.submit()">
                                                <option value="">اختر مندوب</option>
                                                @forelse($delegates as $delegate)
                                                <option value="{{ $delegate->id }}" 
                                                    {{ $order->delegate_id == $delegate->id ? 'selected' : '' }}>
                                                    {{ $delegate->first_name }} {{ $delegate->last_name }}
                                                    @if($delegate->phone)
                                                    - {{ $delegate->phone }}
                                                    @endif
                                                </option>
                                                @empty
                                                <option disabled>لا يوجد مناديب متاحين</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info ms-2">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                </td>
                <td>{{ __('order.'.$order->status->name) }}</td>
                <td>
                    @if($order->delegate)
                    {{ $order->delegate->first_name }} {{ $order->delegate->last_name }}
                    @else
                    لم يتم التعيين
                    @endif
                </td>
                <td>{{ __('order.'.$order->pay_type->name) }}</td>
                <td>{{ number_format($order->total_price, 2) }}</td>
                <td>{{ $order->id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $orders->links() }}
      <!-- Pagination Buttons -->
      <div class="d-flex justify-content-between mt-4">
        <!-- Previous Page Button -->
        @if($orders->onFirstPage())
        <span class="btn btn-secondary btn-rounded disabled">السابق</span>
        @else
        <a href="{{ $orders->previousPageUrl() }}" class="btn btn-primary btn-rounded">السابق</a>
        @endif

        <!-- Next Page Button -->
        @if($orders->hasMorePages())
        <a href="{{ $orders->nextPageUrl() }}" class="btn btn-primary btn-rounded">التالي</a>
        @else
        <span class="btn btn-secondary btn-rounded disabled">التالي</span>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush