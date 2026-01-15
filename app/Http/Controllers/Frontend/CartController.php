<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // Display cart page
    public function index()
    {
        $cart = session()->get('cart', []);

        $items = array_values($cart);
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        
        $tax = $subtotal * 0.10; // 10% tax
        $total = $subtotal + $tax;

        return view('frontend.home.cart', compact('items', 'subtotal', 'tax', 'total'));
    }

    // Add product to cart (AJAX)
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->quantity ? (int) $request->quantity : 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->ProductName,
                'price' => $product->OfferPrice ? $product->OfferPrice : $product->Price,
                'original_price' => $product->Price,
                'offer_price' => $product->OfferPrice,
                'image' => $product->primaryImage->image_url ?? asset('images/default-product.png'),
                'quantity' => $qty,
                'category' => $product->category->categoryName ?? 'Uncategorized'
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // Update quantity
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Product not in cart'], 404);
        }

        $cart[$productId]['quantity'] = (int) $request->quantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true, 
            'message' => 'Cart updated',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    // Remove item
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true, 
                'message' => 'Item removed', 
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        return response()->json([
            'success' => true, 
            'message' => 'Cart cleared',
            'cart_count' => 0
        ]);
    }

    // Get cart count
    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => array_sum(array_column($cart, 'quantity'))]);
    }
}