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
    <h2>تعديل المنتج</h2>

    <form action="{{ route('store.products.update', [$product->id, $product->product_category_id]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <!-- Success Message -->
        @if (Session::has('success'))
            <div class="alert alert-success" style="background:#28272f; color: white;">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <div class="text-center">
            <label for="">{{__('admin.image')}}</label>
            <div class="mb-3 d-flex justify-content-center align-items-center">
                <div id="imageContainer" class="image-upload-square border">
                    @if ($product->image)
                        <img id="previewImage" src="{{ asset('/images/product/' . basename($product->image)) }}" 
                             alt="Image Preview" 
                             style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                    @endif
                    <button id="removeImage" type="button" 
                            class="btn btn-danger btn-sm" 
                            style="position: absolute; top: 5px; right: 5px; display: {{ $product->image ? 'block' : 'none' }};">
                        <i class="fas fa-trash"></i>
                    </button>
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
            <textarea name="description" class="form-control text-end" id="description">{{ $product->description }}</textarea>
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
            <div>
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
            <div>
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
            <div>
                <label>
                    <input type="radio" name="is_frequent" value="1" {{ $product->is_frequent ? 'checked' : '' }}> نعم
                </label>
                <label>
                    <input type="radio" name="is_frequent" value="0" {{ !$product->is_frequent ? 'checked' : '' }}> لا
                </label>
            </div>
            <span class="text-danger">@error('is_frequent'){{ $message }}@enderror</span>
        </div>

        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
        <a href="{{ route('store.products.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
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