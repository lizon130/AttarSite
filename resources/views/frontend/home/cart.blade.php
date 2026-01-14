@extends('frontend.layouts.app')



@section('title', 'Al-Noor | Premium Islamic Store')

<style>
    :root {
        --primary: #0f3d28;
        /* Deep Emerald */
        --secondary: #d4af37;
        /* Gold */
        --light-bg: #fdfbf7;
        /* Warm Cream */
        --dark-text: #2d3436;
    }

    body {
        font-family: 'Outfit', sans-serif;
        color: var(--dark-text);
        background-color: var(--light-bg);
    }

    h1,
    h2,
    h3,
    .font-arabic {
        font-family: 'Amiri', serif;
    }

    /* --- Navbar --- */
    .navbar {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 15px 0;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.8rem;
        color: var(--primary);
    }

    /* --- Page Header --- */
    .page-header {
        background: var(--primary);
        color: #fff;
        padding: 40px 0;
        text-align: center;
        margin-bottom: 40px;
    }

    /* --- Cart Table --- */
    .table thead th {
        border-bottom: 2px solid var(--secondary);
        font-weight: 600;
        color: var(--primary);
        font-size: 0.9rem;
        text-transform: uppercase;
    }

    .cart-item-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .qty-input {
        width: 50px;
        text-align: center;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }

    .remove-btn {
        color: #e74c3c;
        transition: all 0.2s;
        background: none;
        border: none;
    }

    .remove-btn:hover {
        color: #c0392b;
        transform: scale(1.1);
    }

    /* --- Cart Summary Card --- */
    .cart-summary {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border-top: 4px solid var(--secondary);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: #666;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
        font-family: 'Amiri', serif;
    }

    .btn-checkout {
        background-color: var(--primary);
        color: #fff;
        border: none;
        padding: 15px;
        width: 100%;
        font-weight: 600;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .btn-checkout:hover {
        background-color: var(--secondary);
        color: var(--primary);
    }

    /* --- Coupon Input --- */
    .coupon-input {
        border-right: none;
    }

    .coupon-btn {
        background-color: #333;
        color: #fff;
        border: 1px solid #333;
    }

    .coupon-btn:hover {
        background-color: #000;
    }

    @media (max-width: 768px) {
        .cart-item-img {
            width: 60px;
            height: 60px;
        }

        .table-responsive {
            font-size: 0.9rem;
        }
    }
</style>

@section('content')

    <!-- Cart Section -->
    <section class="pb-5 mt-5">
        <div class="container">
            <div class="row">

                <!-- Left: Cart Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col" class="ps-4">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @forelse($items ?? [] as $item)
                                        <tr data-id="{{ $item['id'] }}">
                                            <td class="ps-4 py-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                        class="cart-item-img me-3">
                                                    <div>
                                                        <h6 class="mb-1 fw-bold">{{ $item['name'] }}</h6>
                                                        <small class="text-muted">SKU: PROD{{ str_pad($item['id'], 5, '0', STR_PAD_LEFT) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4">${{ number_format($item['price'], 2) }}</td>
                                            <td class="py-4">
                                                <input type="number" class="qty-input item-qty" value="{{ $item['quantity'] }}" min="1" data-id="{{ $item['id'] }}">
                                            </td>
                                            <td class="py-4 fw-bold text-success item-total">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td class="py-4 text-end pe-4">
                                                <button class="remove-btn remove-item" data-id="{{ $item['id'] }}" title="Remove Item"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Your cart is empty.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 p-3 d-flex flex-wrap gap-2 justify-content-between">
                            <a href="{{ route('public.product') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Continue Shopping</a>
                            <button id="clearCart" class="btn btn-outline-dark btn-sm"><i class="fas fa-trash me-2"></i>Clear Cart</button>
                        </div>
                    </div>

                    <!-- Coupon Section -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <label class="fw-bold mb-2"><i class="fas fa-tag me-2 text-warning"></i>Have a coupon?</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control coupon-input" placeholder="Enter coupon code"
                                    aria-label="Coupon Code">
                                <button class="btn btn-coupon" type="button">Apply Coupon</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="font-arabic mb-4 border-bottom pb-3">Order Summary</h4>

                        <div class="summary-row">
                            <span>Subtotal ({{ array_sum(array_column($items ?? [], 'quantity')) }} items)</span>
                            <span>${{ number_format($subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (Estimated)</span>
                            <span>${{ number_format(($subtotal ?? 0) * 0.10, 2) }}</span>
                        </div>

                        <div class="total-row">
                            <span>Total</span>
                            <span>${{ number_format(($subtotal ?? 0) + (($subtotal ?? 0) * 0.10), 2) }}</span>
                        </div>

                        <div class="mt-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shippingMethod" id="ship1" checked>
                                <label class="form-check-label small" for="ship1">
                                    Standard Shipping (Free - 5-7 Days)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shippingMethod" id="ship2">
                                <label class="form-check-label small" for="ship2">
                                    Express Shipping ($15.00 - 2-3 Days)
                                </label>
                            </div>
                        </div>

                        <button class="btn-checkout mb-3">Proceed to Checkout</button>

                        <div class="text-center mt-3">
                            <p class="small text-muted mb-2">Secure Checkout Guarantee</p>
                            <div class="d-flex justify-content-center gap-2">
                                <i class="fab fa-cc-visa fa-2x text-secondary"></i>
                                <i class="fab fa-cc-mastercard fa-2x text-secondary"></i>
                                <i class="fab fa-cc-paypal fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Cross-sell -->
    <section class="bg-white py-5 border-top">
        <div class="container">
            <h4 class="text-center font-arabic mb-4" style="color: var(--primary);">You may be interested in</h4>
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100">
                        <img src="https://picsum.photos/seed/whitecap/200/200" class="card-img-top mx-auto"
                            style="width: 100px; margin-top:10px;" alt="Cap">
                        <div class="card-body text-center">
                            <h6 class="fw-bold small">Embroidered Tupi</h6>
                            <button class="btn btn-sm btn-outline-dark rounded-pill mt-2">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100">
                        <img src="https://picsum.photos/seed/boxgift/200/200" class="card-img-top mx-auto"
                            style="width: 100px; margin-top:10px;" alt="Gift Box">
                        <div class="card-body text-center">
                            <h6 class="fw-bold small">Gift Wrapping</h6>
                            <button class="btn btn-sm btn-outline-dark rounded-pill mt-2">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('scripts')
<script>
    // Update cart count badge across the site
    function updateCartCount() {
        $.get('{{ route("cart.count") }}', function(res) {
            $('.badge-cart').text(res.count || 0);
        }).fail(function() {
            // silently fail
        });
    }

    // Remove an item from the cart (row removal + reload)
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault();
        if (!confirm('Remove this item?')) return;
        var id = $(this).data('id');
        var row = $(this).closest('tr');
        $.ajax({
            url: '{{ url("/cart/remove") }}/' + id,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                if (res.success) {
                    toastr.success(res.message || 'Item removed');
                    updateCartCount();
                    // Remove row and refresh totals (reload for simplicity)
                    location.reload();
                }
            },
            error: function() { toastr.error('Could not remove item'); }
        });
    });

    // Change quantity
    $(document).on('change', '.item-qty', function() {
        var id = $(this).data('id');
        var qty = parseInt($(this).val()) || 1;
        if (qty < 1) { qty = 1; $(this).val(qty); }
        $.post('{{ route("cart.update") }}', { _token: '{{ csrf_token() }}', product_id: id, quantity: qty }, function(res) {
            if (res.success) {
                toastr.success(res.message || 'Cart updated');
                updateCartCount();
                location.reload();
            }
        }).fail(function() { toastr.error('Failed to update cart'); });
    });

    // Clear cart
    $('#clearCart').on('click', function(e) {
        e.preventDefault();
        if (!confirm('Clear the cart?')) return;
        $.post('{{ route("cart.clear") }}', { _token: '{{ csrf_token() }}' }, function(res) {
            if (res.success) {
                toastr.success(res.message || 'Cart cleared');
                updateCartCount();
                location.reload();
            }
        }).fail(function() { toastr.error('Failed to clear cart'); });
    });

    // Initialize badge
    $(function(){ updateCartCount(); });
</script>
@endpush

@endsection