<?php

namespace App\Http\Controllers\Store;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Store\Category\StoreCategoryRequest;
use App\Http\Requests\Store\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    // View all categories
    public function index()
    {
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();
        return view('Store.categories.index', compact('categories'));
    }

    // Store a new category
    public function store(StoreCategoryRequest $request)
    {
        ProductCategory::create($request->validated() + ['store_id' => Auth::guard('store')->id()]);
        return redirect()->back()->with('success', 'تم إنشاء الفئة بنجاح.');
    }

    // Update a category
    public function update(UpdateCategoryRequest $request, $id)
    {
        ProductCategory::find($id)->update($request->validated());
        return redirect()->back()->with('success', 'تم تحديث الفئة بنجاح.');
    }

    // Delete a category
    public function destroy($id)
    {
        $category = ProductCategory::find($id);
        if ($category->hasProducts()) {
            return redirect()->back()->with('error', 'لا يمكن حذف الفئة لأنها تحتوي على منتجات.');
        }
        $category->delete();
        return redirect()->back()->with('success', 'تم حذف الفئة بنجاح.');
    }
}
