@extends('Super.layout')

@section('styles')
<style>
    .modal-content {
        direction: rtl;
        text-align: right;
    }
    .modal-body .form-label {
        font-weight: bold;
    }
    .modal-body .list-group-item {
        border: none;
        padding: 0.5rem 0;
    }
</style>
@endsection

@section('main')
<div class="container text-end">
    <h2>جميع مديري المناطق</h2>

    <!-- Success/Error Messages -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- Create Admin Button -->
    <button class="btn btn-primary btn-rounded btn-fw mb-4" data-bs-toggle="modal" data-bs-target="#createAdminModal">
        إضافة مدير جديد
    </button>

    <!-- Admins Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>المنطقة</th>
                <th>البريد الإلكتروني</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
            <tr>
                <td>
                    <form action="{{ route('super.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
                <td>{{ $admin->area }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->id }}</td>
            </tr>

            <!-- Show Admin Modal -->
            <div class="modal fade" id="showAdminModal{{ $admin->id }}" tabindex="-1" aria-labelledby="showAdminModalLabel{{ $admin->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showAdminModalLabel{{ $admin->id }}">تفاصيل المسؤول</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>الاسم:</strong> <span id="show-name-{{ $admin->id }}"></span></li>
                                <li class="list-group-item"><strong>البريد الإلكتروني:</strong> <span id="show-email-{{ $admin->id }}"></span></li>
                                <li class="list-group-item"><strong>المنطقة:</strong> <span id="show-area-{{ $admin->id }}"></span></li>
                            </ul>
                            <div id="show-error-{{ $admin->id }}" class="text-danger mt-2" style="display: none;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="5" class="text-center">لا توجد مسؤولين متاحين.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Create Admin Modal -->
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="createAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('super.admins.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAdminModalLabel">إضافة مسؤول جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Area -->
                        <div class="mb-3">
                            <label for="area" class="form-label">المنطقة</label>
                            <input type="text" name="area" id="area" class="form-control" value="{{ old('area') }}" required>
                            @error('area')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection