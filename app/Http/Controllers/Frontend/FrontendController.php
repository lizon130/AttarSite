<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 'active')->get();

        $products = Product::where('status', 'active')
            ->with('primaryImage') // Load primary image
            ->latest()
            ->take(8) // Limit to 8 products for trending section
            ->get();

        // Remove the duplicate categories query since you already have $categories above
        // Or if you need the count, modify the original query:
        $categories = Category::where('status', 'active')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('products_count', '>', 0)
            ->get();

        return view('frontend.home.index', compact('categories', 'products'));
    }

    public function product(Request $request)
    {
        // Get categories for sidebar
        $categories = Category::where('status', 'active')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('products_count', '>', 0)
            ->get();

        // Build product query
        $productsQuery = Product::where('status', 'active')
            ->with(['category', 'primaryImage', 'images'])
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $productsQuery->where('CategoryId', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $productsQuery->whereBetween('Price', [$request->min_price, $request->max_price]);
        } elseif ($request->filled('min_price')) {
            $productsQuery->where('Price', '>=', $request->min_price);
        } elseif ($request->filled('max_price')) {
            $productsQuery->where('Price', '<=', $request->max_price);
        }

        // Sort products
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $productsQuery->orderBy('Price');
                break;
            case 'price_high':
                $productsQuery->orderBy('Price', 'desc');
                break;
            case 'name':
                $productsQuery->orderBy('ProductName');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        // Get paginated products
        $products = $productsQuery->paginate(9);

        return view('frontend.home.product', compact('categories', 'products', 'sort'));
    }

    public function productDetails($id)
    {
        $product = Product::with(['category', 'subCategory', 'images'])
            ->where('status', 'active')
            ->findOrFail($id);

        // Ensure reviews collection exists (some projects may not have reviews implemented yet)
        if (method_exists($product, 'reviews')) {
            $product->load('reviews');
        } else {
            $product->setRelation('reviews', collect());
        }

        // Related products (same category)
        $relatedProducts = Product::where('status', 'active')
            ->where('CategoryId', $product->CategoryId)
            ->where('id', '!=', $id)
            ->with('primaryImage')
            ->limit(4)
            ->get();

        return view('frontend.home.product_details', compact('product', 'relatedProducts'));
    }
    public function cart()
    {
        $cart = session()->get('cart', []);
        $items = array_values($cart);
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        return view('frontend.home.cart', compact('items', 'subtotal'));
    }
}