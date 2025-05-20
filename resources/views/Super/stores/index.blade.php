@extends('Super.layout')

@section('main')
<div class="container text-end">
    <h2>جميع المتاجر</h2>

    <!-- Success/Error Messages -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('super.stores.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="search" class="form-label">البحث حسب الاسم</label>
                <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}" placeholder="أدخل اسم المتجر">
            </div>
            <div class="col-md-4 mb-3">
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

    <!-- Store Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>المسؤول</th>
                <th>التقييم</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stores as $store)
            <tr>
                <td>
                    <a href="{{ route('super.stores.show', $store->id) }}" class="btn btn-info btn-rounded btn-sm" style="display:inline-block;">
                        <i class="fa fa-eye"></i>
                    </a>
                    <form action="{{ route('super.stores.destroy', $store->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('super.stores.changeAdmin', $store->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <select name="admin_id" class="form-select form-select-sm" required>
                                <option value="" {{ is_null($store->admin_id) ? 'selected' : '' }}>لا يوجد مسؤول</option>
                                @foreach ($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $store->admin_id == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->area }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">تغيير</button>
                        </div>
                        @error('admin_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </form>
                </td>
                <td>{{ $store->rating }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->id }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">لا توجد متاجر متاحة.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="mt-3">
        {{ $stores->appends(['search' => $search, 'status' => $status])->links() }}
    </div>
</div>
@endsection