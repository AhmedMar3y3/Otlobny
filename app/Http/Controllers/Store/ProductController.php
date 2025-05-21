<?php

namespace App\Http\Controllers\Store;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Product\StoreProductRequest;
use App\Http\Requests\Store\Product\UpdateProductRequest;

class ProductController extends Controller
{
    // index all products
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $category_id = $request->query('category_id');

        $query = Product::where('store_id', Auth::guard('store')->id())->with('category');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        if ($category_id && is_numeric($category_id)) {
            $query->where('category_id', $category_id);
        }

        $products = $query->paginate(15);
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();

        return view('Store.products.index', compact('products', 'search', 'status', 'category_id', 'categories'));
    }

    public function show(Product $product, $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('Store.products.show', compact('product'));
    }

    // Store a new product
    public function create()
    {
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();
        return view('Store.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data = $this->calculateDiscountPercentage($data);
        $data['store_id'] = Auth::guard('store')->id();
        Product::create($data);
        return redirect()->route('store.products.index')->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    // Update a product
    public function edit(Product $product, $id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();
        return view('Store.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();

        if (isset($data['has_discount']) && $data['has_discount'] == 0) {
            $data['discount_price'] = null;
            $data['discount_percentage'] = null;
        } else {
            $data = $this->calculateDiscountPercentage($data);
        }

        Product::find($id)->update($data);
        return redirect()->route('store.products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product->hasOrders()) {
            return redirect()->route('store.products.index')->with('error', 'لا يمكن حذف المنتج لأنه يحتوي على طلبات قيد العمل.');
        }
        $product->delete();
        return redirect()->route('store.products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }

    protected function calculateDiscountPercentage(array $data): array
    {
        if (isset($data['discount_price']) && !is_null($data['discount_price']) && $data['price'] > 0) {
            $data['discount_percentage'] = round(
                (1 - ($data['discount_price'] / $data['price'])) * 100,
                2
            );
        } else {
            $data['discount_percentage'] = null;
        }

        return $data;
    }

    // Toggle product active status
    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();
        return redirect()->back()->with('success', 'تم تحديث حالة المنتج بنجاح.');
    }
}
