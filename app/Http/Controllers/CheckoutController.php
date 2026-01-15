<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        $items = array_values($cart);
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        
        $tax = $subtotal * 0.10;
        $shipping = 0; // Free shipping
        $total = $subtotal + $tax + $shipping;
        
        return view('frontend.home.checkout', compact('items', 'subtotal', 'tax', 'shipping', 'total'));
    }

    // Process checkout
    public function store(Request $request)
    {
        // Validate form
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'special_instructions' => 'nullable|string',
            'payment_method' => 'required|in:cod,online',
        ]);
        
        // Get cart
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }
        
        $items = array_values($cart);
        $subtotal = array_reduce($items, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        
        $tax = $subtotal * 0.10;
        $shipping = 0;
        $total = $subtotal + $tax + $shipping;
        
        try {
            DB::beginTransaction();
            
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'country' => $validated['country'],
                'special_instructions' => $validated['special_instructions'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] == 'cod' ? 'pending' : 'pending',
                'order_status' => 'pending',
            ]);
            
            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                    'image' => $item['image'],
                ]);
            }
            
            // Clear cart
            session()->forget('cart');
            
            DB::commit();
            
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    // Order success page
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        if (auth()->check() && $order->user_id != auth()->id()) {
            abort(403);
        }
        
        return view('frontend.home.order_success', compact('order'));
    }

    // Order details page
    public function show($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        
        if (auth()->check() && $order->user_id != auth()->id()) {
            abort(403);
        }
        
        return view('frontend.home.order_details', compact('order'));
    }
}
