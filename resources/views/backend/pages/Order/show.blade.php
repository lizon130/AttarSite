@extends('backend.layout.app')
@section('title', 'Order Details | ' . Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- Order Details Card -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Order Details - {{ $order->order_number }}</h4>
                        <a href="#" class="btn btn-sm btn-secondary float-right">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Order Info -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Customer Information</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Order Number</th>
                                        <td>{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td>{{ $order->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $order->customer_email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $order->customer_phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Shipping & Payment Info -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3">Shipping & Payment</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Shipping Address</th>
                                        <td>
                                            {{ $order->customer_address }}<br>
                                            {{ $order->city }}, {{ $order->state }}<br>
                                            {{ $order->zip_code }}, {{ $order->country }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method</th>
                                        <td>{{ strtoupper($order->payment_method) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td>
                                            <span
                                                class="badge @if ($order->payment_status === 'paid') badge-success @elseif($order->payment_status === 'pending') badge-warning @else badge-danger @endif">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td>
                                            <span
                                                class="badge @if ($order->order_status === 'completed') badge-success @elseif($order->order_status === 'processing') badge-info @elseif($order->order_status === 'pending') badge-warning @else badge-danger @endif">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($order->special_instructions)
                                        <tr>
                                            <th>Special Instructions</th>
                                            <td>{{ $order->special_instructions }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Order Items</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <img src="{{ $item->image }}" alt="{{ $item->product_name }}"
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                    </td>
                                                    <td>
                                                        <strong>{{ $item->product_name }}</strong><br>
                                                        @if ($item->product)
                                                            <small class="text-muted">Product ID:
                                                                {{ $item->product_id }}</small>
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>${{ number_format($item->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Order Summary</h5>
                                        <table class="table">
                                            <tr>
                                                <td>Subtotal</td>
                                                <td class="text-right">${{ number_format($order->subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tax (10%)</td>
                                                <td class="text-right">${{ number_format($order->tax, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping</td>
                                                <td class="text-right">
                                                    @if ($order->shipping > 0)
                                                        ${{ number_format($order->shipping, 2) }}
                                                    @else
                                                        <span class="text-success">Free</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr class="font-weight-bold">
                                                <td>Total Amount</td>
                                                <td class="text-right">${{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <!-- Status Update Form -->
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group" style="width: 300px;">
                                                <select name="order_status" class="form-control" required>
                                                    <option value="pending"
                                                        {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="processing"
                                                        {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                                        Processing</option>
                                                    <option value="completed"
                                                        {{ $order->order_status == 'completed' ? 'selected' : '' }}>
                                                        Completed</option>
                                                    <option value="cancelled"
                                                        {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelled</option>
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-success">
                                            <i class="fas fa-file-invoice"></i> Generate Invoice
                                        </a>
                                        <button class="btn btn-warning" onclick="window.print()">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        @media print {

            .card-header .float-right,
            .btn,
            form {
                display: none !important;
            }
        }
    </style>
@endpush