{{-- resources/views/frontend/home/checkout.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Checkout | ' . Helper::getSettings('application_name') ?? 'Al-Noor')

<style>
    /* Checkout specific styles */
    .checkout-wrapper {
        background: #f8f9fa;
        min-height: 100vh;
        padding: 40px 0;
    }

    .checkout-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    .checkout-title {
        font-family: 'Amiri', serif;
        color: var(--primary);
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(15, 61, 40, 0.1);
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .order-summary {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #ddd;
    }

    .summary-total {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary);
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid var(--primary);
    }

    .payment-method {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .payment-method:hover,
    .payment-method.active {
        border-color: var(--primary);
        background: rgba(15, 61, 40, 0.05);
    }

    .payment-method input {
        margin-right: 10px;
    }

    .btn-checkout {
        background: var(--primary);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-checkout:hover {
        background: var(--secondary);
        color: var(--primary);
    }

    .btn-checkout:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
</style>

@section('content')
    <div class="checkout-wrapper">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="row">
                    <!-- Left: Billing Details -->
                    <div class="col-lg-8 mb-4">
                        <div class="checkout-card">
                            <h3 class="checkout-title">Billing Details</h3>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                           name="customer_name"
                                           value="{{ old('customer_name', auth()->user()->name ?? '') }}">
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                           name="customer_email"
                                           value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                           name="customer_phone"
                                           value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country *</label>
                                    <select class="form-control @error('country') is-invalid @enderror" name="country">
                                        <option value="">Select Country</option>
                                        <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Address *</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          name="customer_address" 
                                          rows="3">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City *</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           name="city" 
                                           value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">State / Province</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                           name="state" 
                                           value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">ZIP / Postal Code *</label>
                                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                           name="zip_code"
                                           value="{{ old('zip_code') }}">
                                    @error('zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Special Instructions (Optional)</label>
                                <textarea class="form-control" name="special_instructions" rows="3">{{ old('special_instructions') }}</textarea>
                            </div>

                            <h3 class="checkout-title mt-4">Payment Method</h3>

                            <div class="payment-method active" onclick="selectPayment('cod')">
                                <input type="radio" name="payment_method" value="cod" id="cod" checked
                                    onchange="togglePaymentFields()">
                                <label for="cod" class="fw-bold">
                                    Cash on Delivery (COD)
                                </label>
                                <p class="small text-muted mb-0">Pay when you receive the order</p>
                            </div>

                            <div class="payment-method" onclick="selectPayment('online')">
                                <input type="radio" name="payment_method" value="online" id="online"
                                    onchange="togglePaymentFields()">
                                <label for="online" class="fw-bold">
                                    Online Payment
                                </label>
                                <p class="small text-muted mb-0">Pay securely with Razorpay</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Order Summary -->
                    <div class="col-lg-4">
                        <div class="checkout-card">
                            <h3 class="checkout-title">Your Order</h3>

                            <div class="order-summary mb-4">
                                @foreach ($items as $item)
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="rounded"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="ms-3 flex-grow-1">
                                            <h6 class="mb-0">{{ $item['name'] }}</h6>
                                            <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold">
                                                ${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                            <small class="text-muted">${{ number_format($item['price'], 2) }} each</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Tax (10%)</span>
                                <span>${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="summary-item">
                                <span>Shipping</span>
                                <span class="text-success">Free</span>
                            </div>

                            <div class="summary-total d-flex justify-content-between">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn-checkout" id="submitBtn">
                                    <i class="fas fa-lock me-2"></i> Place Order
                                </button>
                            </div>

                            <div class="mt-3 text-center small text-muted">
                                <p>By placing your order, you agree to our
                                    <a href="#" class="text-primary">Terms & Conditions</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Simple payment method selection
    function selectPayment(method) {
        $('.payment-method').removeClass('active');
        $('#' + method).closest('.payment-method').addClass('active');
        $('input[name="payment_method"][value="' + method + '"]').prop('checked', true);
    }

    // Payment method click handlers
    $('.payment-method').click(function() {
        var method = $(this).find('input').val();
        selectPayment(method);
    });

    // Prevent double form submission
    $('#checkoutForm').on('submit', function() {
        $('#submitBtn').prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
    });
</script>
@endpush