<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Product\StoreProductRequest;
use App\Http\Requests\admin\Product\UpdateProductRequest;

class ProductController extends Controller
{
    // index all products
    public function index(Request $request)
    {
        $search = $request->query('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(15);
        return view('Admin.products.index', compact('products', 'search'));
    }

    // Show a specific product details
    public function show(Product $product, $id)
    {
        $product = Product::with('category')->find($id);
        return view('Admin.products.show', compact('product'));
    }

    // Show the form to create a new product
    public function create()
    {
        $categories = Category::where('parent_id', '!=', null)->get();
        return view('Admin.products.create', compact('categories'));
    }

    // Store a new product
    public function store(StoreProductRequest $request)
    {
        $validatedData = Product::assignCategory($request->validated());
        Product::create($validatedData);
        return redirect()->route('admin.products.index')->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    // Show the form to edit a product
    public function edit(Product $product, $id)
    {
        $product = Product::find($id);
        $categories = Category::where('parent_id', '!=', null)->get();
        return view('Admin.products.edit', compact('product', 'categories'));
    }

    // Update a product

    public function update(UpdateProductRequest $request, $id)
    {
        Product::find($id)->update($request->validated());
        return redirect()->route('admin.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);
        // if ($product->hasOrders()) {
        //     return redirect()->route('admin.products.index')->with('error', 'لا يمكن حذف المنتج لأنه يحتوي على طلبات قيد العمل.');
        // }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
