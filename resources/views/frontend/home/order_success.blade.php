{{-- resources/views/frontend/home/order_success.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Order Confirmed | ' . Helper::getSettings('application_name') ?? 'Al-Noor')

<style>
    .success-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 60px 0;
    }

    .success-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 40px;
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 2rem;
    }

    .order-details {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin: 30px 0;
        text-align: left;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .btn-success {
        background: var(--primary);
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-success:hover {
        background: var(--secondary);
        color: var(--primary);
    }
</style>

@section('content')
    <div class="success-wrapper">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>

                <h1 class="fw-bold" style="color: var(--primary);">Order Confirmed!</h1>
                <p class="lead text-muted mb-4">Thank you for your purchase. Your order has been received.</p>

                <div class="alert alert-success">
                    <i class="fas fa-info-circle me-2"></i>
                    Order Number: <strong>{{ $order->order_number }}</strong>
                </div>

                <div class="order-details">
                    <div class="detail-item">
                        <span>Order Date:</span>
                        <span>{{ $order->created_at->format('F d, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Customer Name:</span>
                        <span>{{ $order->customer_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Email:</span>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Phone:</span>
                        <span>{{ $order->customer_phone }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Shipping Address:</span>
                        <span class="text-end">{{ $order->customer_address }}, {{ $order->city }},
                            {{ $order->zip_code }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Payment Method:</span>
                        <span>{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="detail-item">
                        <span>Order Total:</span>
                        <span class="fw-bold text-success">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('public.homePage') }}" class="btn btn-success me-3">
                        <i class="fas fa-home me-2"></i> Continue Shopping
                    </a>
                    <a href="{{ route('checkout.show', $order->order_number) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i> View Order Details
                    </a>
                </div>

                <p class="small text-muted mt-4">
                    A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>
                </p>
            </div>
        </div>
    </div>
@endsection