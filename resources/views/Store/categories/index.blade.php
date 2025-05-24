@extends('Store.layout')
@section('styles')
<style>
    .category-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .category-header {
        margin-bottom: 2rem;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .category-header h2 {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .table {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        margin-bottom: 2rem;
    }
    
    .table thead th {
        background: rgba(255,255,255,0.1);
        color: #fff;
        font-weight: 500;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
    }
    
    .table tbody td {
        color: #fff;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
        vertical-align: middle;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.05);
        transform: translateY(-2px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(15,23,42,0.30);
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
    }
    
    .btn-primary:active {
        transform: translateY(0);
    }
    
    .btn-warning {
        background: rgba(255,193,7,0.1);
        border: 1px solid rgba(255,193,7,0.2);
        color: #ffc107;
        padding: 0.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-warning:hover {
        background: rgba(255,193,7,0.2);
        color: #ffc107;
        transform: translateY(-2px);
    }
    
    .btn-warning:active {
        transform: translateY(0);
    }
    
    .btn-danger {
        background: rgba(255,107,107,0.1);
        border: 1px solid rgba(255,107,107,0.2);
        color: #ff6b6b;
        padding: 0.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-danger:hover {
        background: rgba(255,107,107,0.2);
        color: #ff6b6b;
        transform: translateY(-2px);
    }
    
    .btn-danger:active {
        transform: translateY(0);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .alert-success {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #ff6b6b;
        border: 1px solid rgba(255,107,107,0.2);
    }
    
    .modal-content {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        animation: modalSlideIn 0.3s ease;
    }
    
    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1.2rem;
    }
    
    .modal-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 500;
    }
    
    .modal-body {
        padding: 1.5rem;
        color: #fff;
    }
    
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 1.2rem;
    }
    
    .form-label {
        color: #fff !important;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.8rem;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background-color: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        box-shadow: 0 0 0 3px rgba(255,255,255,0.1);
    }
    
    .form-control::placeholder {
        color: rgba(255,255,255,0.5);
    }
    
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
        transition: all 0.3s ease;
    }
    
    .btn-close:hover {
        transform: rotate(90deg);
    }
    
    .text-danger {
        color: #ff6b6b !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .loading {
        position: relative;
        pointer-events: none;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: 50%;
        left: 50%;
        margin: -0.5rem 0 0 -0.5rem;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: rgba(255,255,255,0.7);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: rgba(255,255,255,0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .search-box {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .search-box input {
        padding-right: 2.5rem;
    }
    
    .search-box i {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.5);
    }
</style>
@endsection

@section('main')
<div class="category-container" style="direction: rtl;">
    <div class="category-header">
        <h2>جميع الفئات</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fa fa-plus"></i>
            إضافة فئة جديدة
        </button>
    </div>

    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-2"></i>
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- Search Box -->
    <div class="search-box">
        <input type="text" class="form-control" id="categorySearch" placeholder="ابحث عن فئة...">
        <i class="fa fa-search"></i>
    </div>

    <!-- Category Table -->
    <div class="table-responsive">
        <table class="table">
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
                        <div class="action-buttons">
                            <form action="{{ route('store.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الفئة؟');" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="حذف">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}" title="تعديل">
                                <i class="fa fa-edit"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->id }}</td>
                </tr>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('store.categories.update', $category->id) }}" method="POST" class="category-form">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                                        <i class="fa fa-edit me-2"></i>
                                        تعديل الفئة
                                    </h5>
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
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-2"></i>
                                        حفظ التغييرات
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fa fa-times me-2"></i>
                                        إلغاء
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <i class="fa fa-folder-open"></i>
                            <p>لا توجد فئات متاحة.</p>
                        </div>
                    </td>
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
            <form action="{{ route('store.categories.store') }}" method="POST" class="category-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">
                        <i class="fa fa-plus me-2"></i>
                        إضافة فئة جديدة
                    </h5>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save me-2"></i>
                        حفظ
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-2"></i>
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Form submission loading state
    document.querySelectorAll('.category-form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    });

    // Search functionality
    const searchInput = document.getElementById('categorySearch');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const categoryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (categoryName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Confirmation dialog enhancement
    const deleteButtons = document.querySelectorAll('form[action*="destroy"]');
    deleteButtons.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من حذف هذه الفئة؟')) {
                this.submit();
            }
        });
    });
</script>
@endpush
@endsection