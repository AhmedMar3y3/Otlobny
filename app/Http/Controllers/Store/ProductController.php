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
        $products = Product::where('store_id', Auth::guard('store')->id())->with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(15);
        return view('Store.products.index', compact('products', 'search'));
    }

    // Show a specific product details
    public function show(Product $product, $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('Store.products.show', compact('product'));
    }

    // Show the form to create a new product
    public function create()
    {
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();
        return view('Store.products.create', compact('categories'));
    }

    // Store a new product
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data = $this->calculateDiscountPercentage($data);
        $data['store_id'] = Auth::guard('store')->id();
        Product::create($data);
        return redirect()->route('store.products.index')->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    // Show the form to edit a product
    public function edit(Product $product, $id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::where('store_id', Auth::guard('store')->id())->get();
        return view('Store.products.edit', compact('product', 'categories'));
    }

    // Update a product
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
        // if ($product->hasOrders()) {
        //     return redirect()->route('store.products.index')->with('error', 'لا يمكن حذف المنتج لأنه يحتوي على طلبات قيد العمل.');
        // }
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
}
