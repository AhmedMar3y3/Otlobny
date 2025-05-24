@extends('Store.layout')
@section('styles')
<style>
    .product-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .product-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .product-header h2 {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .card {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        border-radius: 15px;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(15,23,42,0.30);
    }
    
    .card-header {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        color: #fff;
        font-size: 1.2rem;
        font-weight: 500;
        padding: 1.2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .card-body {
        padding: 2rem;
        color: #fff;
    }
    
    .form-label {
        color: #fff !important;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.8rem;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background-color: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        box-shadow: none;
    }
    
    .form-control::placeholder {
        color: rgba(255,255,255,0.5);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(15,23,42,0.30);
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 0.8rem 2rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateY(-2px);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
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
        background: rgba(255,255,255,0.05);
        border: 2px dashed rgba(255,255,255,0.2);
        transition: all 0.3s ease;
    }
    
    .image-upload-square:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.3);
    }
    
    .image-upload-square img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 13px;
    }
    
    .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #fff;
        cursor: pointer;
    }
    
    .radio-group input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #0F172A;
    }
    
    .text-danger {
        color: #ff6b6b !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    .btn-danger {
        background: rgba(255,107,107,0.1);
        border: 1px solid rgba(255,107,107,0.2);
        color: #ff6b6b;
        padding: 0.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        background: rgba(255,107,107,0.2);
        color: #ff6b6b;
        transform: translateY(-2px);
    }
</style>
@endsection
@section('main')

<div class="product-container" style="direction: rtl;">
    <div class="product-header">
        <h2>تعديل المنتج</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('store.products.update', [$product->id, $product->product_category_id]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Success Message -->
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <div class="text-center">
                    <label for="image" class="form-label">{{__('admin.image')}}</label>
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <div id="imageContainer" class="image-upload-square">
                            @if ($product->image)
                                <img id="previewImage" src="{{ asset('/images/product/' . basename($product->image)) }}" 
                                     alt="Image Preview" 
                                     style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                            @else
                                <i class="fas fa-cloud-upload-alt fa-3x" style="color: rgba(255,255,255,0.5);"></i>
                            @endif
                            @if ($product->image)
                                <button id="removeImage" type="button" 
                                        class="btn btn-danger btn-sm" 
                                        style="position: absolute; top: 5px; right: 5px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                    <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                    <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">اسم المنتج</label>
                    <input type="text" name="name" class="form-control text-end" id="name" value="{{ $product->name }}" required>
                    <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" class="form-control text-end" id="description" rows="4">{{ $product->description }}</textarea>
                    <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">السعر</label>
                    <input type="number" name="price" class="form-control text-end" id="price" value="{{ $product->price }}" required>
                    <span class="text-danger">@error('price'){{ $message }}@enderror</span>
                </div>

                <div class="mb-3">
                    <label for="product_category_id" class="form-label">الفئة</label>
                    <select name="product_category_id" class="form-select text-end" id="product_category_id" required>
                        @if ($categories->isEmpty())
                            <option value="">لا توجد فئات متاحة</option>
                        @else
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->product_category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        @endif
                    </select>
                    <span class="text-danger">@error('product_category_id'){{ $message }}@enderror</span>
                </div>

                <!-- Has Discount Radio Buttons -->
                <div class="mb-3">
                    <label class="form-label">هل يوجد خصم؟</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="has_discount" value="1" id="has_discount_yes" {{ $product->has_discount ? 'checked' : '' }}> نعم
                        </label>
                        <label>
                            <input type="radio" name="has_discount" value="0" id="has_discount_no" {{ !$product->has_discount ? 'checked' : '' }}> لا
                        </label>
                    </div>
                    <span class="text-danger">@error('has_discount'){{ $message }}@enderror</span>
                </div>

                <!-- Discount Price Input -->
                <div class="mb-3" id="discount_price_field" style="display: {{ $product->has_discount ? 'block' : 'none' }};">
                    <label for="discount_price" class="form-label">سعر الخصم</label>
                    <input type="number" name="discount_price" class="form-control text-end" id="discount_price" value="{{ $product->discount_price ?? '' }}" {{ $product->has_discount ? '' : 'disabled' }}>
                    <span class="text-danger">@error('discount_price'){{ $message }}@enderror</span>
                </div>

                <!-- Has Stock Radio Buttons -->
                <div class="mb-3">
                    <label class="form-label">هل يوجد مخزون؟</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="has_stock" value="1" id="has_stock_yes" {{ $product->has_stock ? 'checked' : '' }}> نعم
                        </label>
                        <label>
                            <input type="radio" name="has_stock" value="0" id="has_stock_no" {{ !$product->has_stock ? 'checked' : '' }}> لا
                        </label>
                    </div>
                    <span class="text-danger">@error('has_stock'){{ $message }}@enderror</span>
                </div>

                <!-- Stock Input -->
                <div class="mb-3" id="stock_field" style="display: {{ $product->has_stock ? 'block' : 'none' }};">
                    <label for="stock" class="form-label">المخزون</label>
                    <input type="number" name="stock" class="form-control text-end" id="stock" value="{{ $product->stock ?? '' }}" {{ $product->has_stock ? '' : 'disabled' }}>
                    <span class="text-danger">@error('stock'){{ $message }}@enderror</span>
                </div>

                <!-- Is Frequent Radio Buttons -->
                <div class="mb-3">
                    <label class="form-label">منتج يطلب معا؟</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="is_frequent" value="1" {{ $product->is_frequent ? 'checked' : '' }}> نعم
                        </label>
                        <label>
                            <input type="radio" name="is_frequent" value="0" {{ !$product->is_frequent ? 'checked' : '' }}> لا
                        </label>
                    </div>
                    <span class="text-danger">@error('is_frequent'){{ $message }}@enderror</span>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    <a href="{{ route('store.products.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to Toggle Visibility and Disable Fields -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Discount toggle
        const hasDiscountYes = document.getElementById('has_discount_yes');
        const hasDiscountNo = document.getElementById('has_discount_no');
        const discountPriceField = document.getElementById('discount_price_field');
        const discountPriceInput = document.getElementById('discount_price');

        hasDiscountYes.addEventListener('change', function () {
            discountPriceField.style.display = 'block';
            discountPriceInput.disabled = false;
        });
        hasDiscountNo.addEventListener('change', function () {
            discountPriceField.style.display = 'none';
            discountPriceInput.disabled = true;
        });

        // Stock toggle
        const hasStockYes = document.getElementById('has_stock_yes');
        const hasStockNo = document.getElementById('has_stock_no');
        const stockField = document.getElementById('stock_field');
        const stockInput = document.getElementById('stock');

        hasStockYes.addEventListener('change', function () {
            stockField.style.display = 'block';
            stockInput.disabled = false;
        });
        hasStockNo.addEventListener('change', function () {
            stockField.style.display = 'none';
            stockInput.disabled = true;
        });

        // Image preview
        const imageInput = document.getElementById('image');
        const imageContainer = document.getElementById('imageContainer');
        const removeImageButton = document.getElementById('removeImage');

        imageContainer.addEventListener('click', function (event) {
            if (event.target.id !== 'removeImage' && !event.target.closest('#removeImage')) {
                imageInput.click();
            }
        });

        imageInput.addEventListener('change', function () {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imageContainer.innerHTML = `
                        <img id="previewImage" src="${e.target.result}" 
                             alt="Image Preview" 
                             style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                        <button id="removeImage" type="button" 
                                class="btn btn-danger btn-sm" 
                                style="position: absolute; top: 5px; right: 5px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    document.getElementById('removeImage').addEventListener('click', function (e) {
                        e.stopPropagation();
                        imageInput.value = '';
                        imageContainer.innerHTML = '';
                        removeImageButton.style.display = 'none';
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        removeImageButton.addEventListener('click', function (e) {
            e.stopPropagation();
            imageInput.value = '';
            imageContainer.innerHTML = '';
            this.style.display = 'none';
        });
    });
</script>

@endsection