@extends('Super.layout')
@section('styles')
<style>
    body, .container {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
    }
    .page-header {
        color: #fff;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 2rem;
        text-align: center;
    }
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
    }
    .alert-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    .alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    .btn-add-category {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    .btn-add-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .table-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    .table {
        color: #fff;
        margin-bottom: 0;
    }
    .table thead th {
        border-bottom: 2px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        font-weight: 500;
        padding: 1rem;
    }
    .table tbody td {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
        vertical-align: middle;
    }
    .table tbody tr {
        transition: all 0.3s ease;
    }
    .table tbody tr:hover {
        background: rgba(255,255,255,0.05);
    }
    .btn-action {
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin-left: 0.5rem;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        border: none;
    }
    .btn-delete:hover {
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
        border: none;
    }
    .btn-edit:hover {
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }
    .modal-content {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: none;
        border-radius: 15px;
        color: #fff;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    }
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem;
        position: relative;
    }
    .modal-header::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    }
    .modal-title {
        color: #fff;
        font-weight: 600;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .modal-title i {
        color: #3b82f6;
    }
    .modal-body {
        padding: 2rem;
    }
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem;
        position: relative;
    }
    .modal-footer::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
    }
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-label i {
        color: #3b82f6;
        font-size: 0.9rem;
    }
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 0.875rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    .form-control:focus {
        background: rgba(255,255,255,0.1);
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        color: #fff;
    }
    .form-control::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    .text-danger {
        color: #ef4444 !important;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .text-danger::before {
        content: '!';
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        background: #ef4444;
        color: #fff;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: bold;
    }
    .btn-modal {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
    }
    .btn-modal-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
    }
    .btn-modal-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-modal-secondary {
        background: rgba(255,255,255,0.1);
        color: #94a3b8;
    }
    .btn-modal-secondary:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }
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
    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    @media (max-width: 768px) {
        .page-container {
            padding: 1rem 0;
        }
        .page-header {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .table-container {
            padding: 1rem;
        }
        .table thead th,
        .table tbody td {
            padding: 0.75rem;
        }
    }
</style>
@endsection
@section('main')
<div class="page-container" dir="rtl">
    <h2 class="page-header">جميع الفئات</h2>

    <!-- Success/Error Messages -->
    @if (Session::has('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Add Category Button -->
    <button class="btn btn-add-category" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="fas fa-plus me-2"></i>
        إضافة فئة جديدة
    </button>

    <!-- Category Table -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>الإجراءات</th>
                    <th>الاسم</th>
                    <th>الصورة</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td>
                        <form action="{{ route('super.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟');" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-action btn-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        <button class="btn btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    <td>{{ $category->name }}</td>
                    <td class="p-0">
                        <img src="{{ $category->image }}" alt="Image" style="border-radius: 0%; height: 55px; width: 55px;">
                    </td>
                    <td>{{ $category->id }}</td>
                </tr>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('super.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                                        <i class="fas fa-edit"></i>
                                        تعديل الفئة
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Category Name -->
                                    <div class="mb-4">
                                        <label for="editCategoryName{{ $category->id }}" class="form-label">
                                            <i class="fas fa-tag"></i>
                                            اسم الفئة
                                        </label>
                                        <input type="text" name="name" class="form-control" id="editCategoryName{{ $category->id }}" value="{{ $category->name }}" required>
                                    </div>
                                    <!-- Category Image -->
                                    <div class="text-center">
                                        <label for="" class="form-label">
                                            <i class="fas fa-image"></i>
                                            {{__('admin.image')}}
                                        </label>
                                        <div class="mb-3 d-flex justify-content-center align-items-center">
                                            <div id="imageContainer{{ $category->id }}" class="image-upload-square border">
                                                <img id="previewImage{{ $category->id }}" src="{{ $category->image }}" 
                                                     alt="Image Preview" 
                                                     style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                                                <button id="removeImage{{ $category->id }}" type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        style="position: absolute; top: 5px; right: 5px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="file" id="image{{ $category->id }}" name="image" class="form-control d-none" accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-modal btn-modal-primary">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ التغييرات
                                    </button>
                                    <button type="button" class="btn btn-modal btn-modal-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center">لا توجد فئات متاحة.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('super.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">
                        <i class="fas fa-plus"></i>
                        إضافة فئة جديدة
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Category Name -->
                    <div class="mb-4">
                        <label for="categoryName" class="form-label">
                            <i class="fas fa-tag"></i>
                            اسم الفئة
                        </label>
                        <input type="text" name="name" class="form-control" id="categoryName" required>
                    </div>
                    <!-- Category Image -->
                    <div class="text-center">
                        <label for="" class="form-label">
                            <i class="fas fa-image"></i>
                            {{__('admin.image')}}
                        </label>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div id="imageContainerCreate" class="image-upload-square border">
                            </div>
                        </div>
                        <input type="file" id="imageCreate" name="image" class="form-control d-none" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-modal btn-modal-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ
                    </button>
                    <button type="button" class="btn btn-modal btn-modal-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handle image upload and removal for all modals
        document.querySelectorAll('.modal').forEach(modal => {
            const imageInput = modal.querySelector('input[type="file"]');
            const imageContainer = modal.querySelector('.image-upload-square');

            if (imageContainer && imageInput) {
                // Handle clicking on the container to open file dialog
                imageContainer.addEventListener('click', function () {
                    imageInput.click();
                });

                // Handle file input change
                imageInput.addEventListener('change', function () {
                    const file = imageInput.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            // Update container HTML with image and remove button
                            imageContainer.innerHTML = `
                                <img src="${e.target.result}" 
                                     alt="Image Preview" 
                                     style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        style="position: absolute; top: 5px; right: 5px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;

                            // Add event listener to the remove button
                            const removeButton = imageContainer.querySelector('button');
                            removeButton.addEventListener('click', function (e) {
                                e.stopPropagation(); // Prevent file input click from being triggered
                                imageInput.value = '';
                                imageContainer.innerHTML = ''; // Remove image and button
                            });
                        };

                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                });
            }
        });
    });
</script>
@endsection