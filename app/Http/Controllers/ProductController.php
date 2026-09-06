<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('short_desc_ar', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }

    public function show($category_slug, $product_slug)
    {
        $category = Category::where('slug', $category_slug)->firstOrFail();
        $product = Product::where('slug', $product_slug)
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $category->id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(5)
            ->get();

        return view('products.show', compact('product', 'category', 'relatedProducts'));
    }
}
