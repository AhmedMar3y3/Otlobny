<?php

namespace App\Http\Controllers\Admin;

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
        return view('Admin.categories.index', compact('categories'));
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
}
