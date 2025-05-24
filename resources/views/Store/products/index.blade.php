@extends('Store.layout')

@section('styles')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-group .btn,
        .btn {
            margin-left: 0.5rem;
        }

        .form-select,
        .form-control {
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

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white mb-0">المنتجات</h2>
                    <div>
                        <a href="{{ route('store.products.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i>
                            إضافة منتج جديد
                        </a>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('store.products.index') }}" class="mb-4">
                    <div class="row justify-content-end">
                        <div class="col-md-6 mb-3">
                            <label for="search" class="form-label text-white">البحث حسب الاسم</label>
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}"
                                    placeholder="أدخل اسم المنتج">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label text-white">الحالة</label>
                            <select name="status" id="status" class="form-select">
                                <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>الكل</option>
                                <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>الإجراءات</th>
                                <th>الصورة</th>
                                <th>الحالة</th>
                                <th>السعر</th>
                                <th>الاسم</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('store.products.show', $product->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('store.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('store.products.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        @if($product->image)
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                        @else
                                            <span class="badge bg-secondary">لا توجد صورة</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('store.products.toggleActive', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn {{ $product->is_active ? 'btn-success' : 'btn-secondary' }} btn-sm">
                                                <i class="fa {{ $product->is_active ? 'fa-check' : 'fa-times' }} me-1"></i>
                                                {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa fa-money-bill me-1"></i>
                                            {{ number_format($product->price, 2) }}
                                        </span>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->id }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد منتجات متاحة.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $products->appends(['search' => $search, 'status' => $status, 'category_id' => $category_id])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection