@extends('Store.layout')

@section('styles')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-group .btn {
            margin-left: 0.5rem;
        }

        .form-select-sm {
            width: auto;
            display: inline-block;
        }
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <h1>الطلبات</h1>

        @if (Session::has('success'))
            <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <!-- Status Filter Form -->
        <form method="GET" action="{{ route('store.orders.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">حالة الطلب</label>
                    <select name="status" id="status" class="form-select form-select-sm">
                        <option value="" {{ $status === null || $status === '' ? 'selected' : '' }}>الكل</option>
                        @foreach ($statuses as $enumStatus)
                            <option value="{{ $enumStatus->value }}" {{ $status == $enumStatus->value ? 'selected' : '' }}>
                                {{ __('order.' . $enumStatus->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm">تصفية</button>
                </div>
            </div>
        </form>

        <!-- Orders Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الإجراءات</th>
                    <th>الحالة</th>
                    <th>المندوب</th>
                    <th>السعر</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('store.orders.show', $order) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if ($order->status === \App\Enums\OrderStatus::PREPARING)
                                    <form action="{{ route('store.orders.markAsWaiting', $order) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('هل أنت متأكد من تحديث حالة الطلب إلى قيد الانتظار؟');">
                                            <i class="fa fa-clock"></i> قيد الانتظار
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td>{{ __('order.' . $order->status->name) }}</td>
                        <td>
                            @if ($order->delegate)
                                {{ $order->delegate->first_name }} {{ $order->delegate->last_name }}
                            @else
                                لم يتم التعيين
                            @endif
                        </td>
                        <td>{{ number_format($order->price, 2) }}</td>
                        <td>{{ $order->id }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">لا توجد طلبات متاحة.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $orders->appends(['status' => $status])->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush