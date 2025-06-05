<?php

namespace App\Http\Controllers\Super;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Category\StoreCategoryRequest;
use App\Http\Requests\admin\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    // View all categories
    public function index()
    {
        $categories = Category::get();
        return view('Super.categories.index', compact('categories'));
    }

    // Store a new category
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->back()->with('success', 'تم إنشاء الفئة بنجاح.');
    }

    // Update a category
    public function update(UpdateCategoryRequest $request, $id)
    {
        Category::find($id)->update($request->validated());
        return redirect()->back()->with('success', 'تم تحديث الفئة بنجاح.');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->hasStores()) {
            return redirect()->back()->with('error', 'لا يمكن حذف الفئة لأنها تحتوي على منتجات.');
        }
        $category->delete();
        return redirect()->back()->with('success', 'تم حذف الفئة بنجاح.');
    }

    public function getStoresByCategory($id)
    {
        $category = Category::findOrFail($id);
        $query = $category->stores();

        if (request()->has('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $stores = $query->paginate(15);
        return view('Super.categories.stores', compact('stores', 'category'));
    }

    public function getStoreProducts($categoryId, $storeId)
    {
        $category = Category::findOrFail($categoryId);
        $store = $category->stores()->findOrFail($storeId);
        $query = $store->products();

        if (request()->has('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(15);
        return view('Super.categories.store-products', compact('products', 'store', 'category'));
    }

    public function showStoreProduct($categoryId, $storeId, $productId)
    {
        $category = Category::findOrFail($categoryId);
        $store = $category->stores()->findOrFail($storeId);
        $product = $store->products()->findOrFail($productId);
        return view('Super.categories.show-store-product', compact('product', 'store', 'category'));
    }

    public function deleteStoreProduct($categoryId, $storeId, $productId)
    {
        $category = Category::findOrFail($categoryId);
        $store = $category->stores()->findOrFail($storeId);
        $product = $store->products()->findOrFail($productId);

        $product->delete();

        $redirectTo = request('redirect_to', route('super.categories.store-products', [$categoryId, $storeId]));
        return redirect($redirectTo)->with('success', 'تم حذف المنتج بنجاح.');
    }
}
