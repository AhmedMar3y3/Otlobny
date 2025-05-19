@extends('Store.layout')
@section('styles')
<style>
    .image-upload-square {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        width: 250px; 
        height: 250px;
        border-radius: 15px;
    }

    .image-upload-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .image-upload-square:hover {
        background-color: #9fa0a0;
    }
</style>
@endsection
@section('main')

<div class="container text-end">
    <h2>جميع الفئات</h2>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    <!-- Add Category Button -->
    <button class="btn btn-primary btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#createCategoryModal" style="margin: 10px">
        إضافة فئة جديدة
    </button>

    <!-- Category Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>الإجراءات</th>
                <th>الاسم</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>
                    <form action="{{ route('store.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-trash"></i></button>
                    </form>
                    <button class="btn btn-warning btn-rounded btn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>
                <td>{{ $category->title }}</td>
                <td>{{ $category->id }}</td>
            </tr>

            <!-- Edit Category Modal -->
            <div class="modal fade text-end" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('store.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">تعديل الفئة</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Category Title -->
                                <div class="mb-3">
                                    <label for="editCategoryTitle{{ $category->id }}" class="form-label">اسم الفئة</label>
                                    <input type="text" name="title" class="form-control text-end" id="editCategoryTitle{{ $category->id }}" value="{{ $category->title }}" required>
                                    <span class="text-danger">@error('title'){{ $message }}@enderror</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="3" class="text-center">لا توجد فئات متاحة.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Create Category Modal -->
<div class="modal fade text-end" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('store.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">إضافة فئة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Category Title -->
                    <div class="mb-3">
                        <label for="categoryTitle" class="form-label">اسم الفئة</label>
                        <input type="text" name="title" class="form-control text-end" id="categoryTitle" required>
                        <span class="text-danger">@error('title'){{ $message }}@enderror</span>
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

@endsection