<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        // Log the incoming request data
        Log::info('Checkout form submitted with data:', $request->all());
        
        // Validate form - ONLY LARAVEL VALIDATION
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'special_instructions' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,online',
        ], [
            'customer_name.required' => 'Please enter your full name.',
            'customer_email.required' => 'Please enter your email address.',
            'customer_email.email' => 'Please enter a valid email address.',
            'customer_phone.required' => 'Please enter your phone number.',
            'customer_address.required' => 'Please enter your address.',
            'city.required' => 'Please enter your city.',
            'zip_code.required' => 'Please enter your ZIP/postal code.',
            'country.required' => 'Please select your country.',
            'payment_method.required' => 'Please select a payment method.',
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
        
        Log::info('Cart items:', $items);
        Log::info('Calculated amounts - Subtotal: ' . $subtotal . ', Tax: ' . $tax . ', Total: ' . $total);
        
        try {
            DB::beginTransaction();
            
            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
            
            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id() ?? null,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'city' => $validated['city'],
                'state' => $validated['state'] ?? null,
                'zip_code' => $validated['zip_code'],
                'country' => $validated['country'],
                'special_instructions' => $validated['special_instructions'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] == 'cod' ? 'pending' : 'pending',
                'order_status' => 'pending',
            ]);
            
            Log::info('Order created successfully:', $order->toArray());
            
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
                
                Log::info('Order item created:', [
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                ]);
            }
            
            // Clear cart
            session()->forget('cart');
            
            DB::commit();
            
            Log::info('Order ' . $orderNumber . ' placed successfully.');
            
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Order placed successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Failed to place order: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->with('error', 'Failed to place order: ' . $e->getMessage())
                ->withInput();
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