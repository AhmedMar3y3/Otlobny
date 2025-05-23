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
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <h2>جميع المنتجات</h2>

        <!-- Success/Error Messages -->
        @if (Session::has('success'))
            <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <!-- Add Product Button -->
        <a href="{{ route('store.products.create') }}" class="btn btn-primary btn-rounded btn-fw mb-4">
            إضافة منتج جديد
        </a>

        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('store.products.index') }}" class="mb-4 text-end">
            <div class="row justify-content-end">
                <div class="col-md-6 mb-6">
                    <label for="search" class="form-label">البحث حسب الاسم</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}"
                        placeholder="أدخل اسم المنتج">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label">الحالة</label>
                    <select name="status" id="status" class="form-select">
                        <option value="all" {{ ($status ?? 'all') === 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </form>

        <!-- Products Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الإجراءات</th>
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
                            <form action="{{ route('store.products.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i
                                        class="fa fa-trash"></i></button>
                            </form>
                            <a href="{{ route('store.products.edit', $product->id) }}"
                                class="btn btn-warning btn-rounded btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('store.products.show', $product->id) }}" class="btn btn-info btn-rounded btn-sm"
                                style="display:inline-block;">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('store.products.toggleActive', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $product->is_active ? 'btn-success' : 'btn-secondary' }} btn-sm">
                                    {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->id }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="color: black">لا توجد منتجات متاحة.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $products->appends(['search' => $search, 'status' => $status, 'category_id' => $category_id])->links() }}
        </div>
    </div>
@endsection