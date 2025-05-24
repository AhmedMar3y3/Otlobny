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

        .card {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(15,23,42,0.30);
        }

        .table {
            color: #fff;
        }

        .table-dark {
            background-color: transparent;
        }

        .table-dark thead th {
            border-bottom: 2px solid rgba(255,255,255,0.1);
            color: #fff;
        }

        .table-dark td, .table-dark th {
            border-color: rgba(255,255,255,0.1);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .alert-success {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #fff;
        }

        .form-control, .form-select {
            background-color: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }

        .form-control:focus, .form-select:focus {
            background-color: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .badge {
            padding: 0.5em 1em;
            font-weight: 500;
        }
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white mb-0">الطلبات</h2>
                    <span class="badge bg-primary p-2">
                        <i class="fa fa-shopping-cart me-1"></i>
                        إدارة الطلبات
                    </span>
                </div>

                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <!-- Status Filter Form -->
                <form method="GET" action="{{ route('store.orders.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label text-white">حالة الطلب</label>
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
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fa fa-filter me-1"></i>
                                تصفية
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
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
                                                        <i class="fa fa-clock me-1"></i> قيد الانتظار
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                            {{ __('order.' . $order->status->name) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($order->delegate)
                                            <span class="badge bg-secondary">
                                                <i class="fa fa-user me-1"></i>
                                                {{ $order->delegate->first_name }} {{ $order->delegate->last_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fa fa-times me-1"></i>
                                                لم يتم التعيين
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa fa-money-bill me-1"></i>
                                            {{ number_format($order->price, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->id }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد طلبات متاحة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $orders->appends(['status' => $status])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush