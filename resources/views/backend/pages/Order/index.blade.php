@extends('backend.layout.app')
@section('title', 'Orders | ' . Helper::getSettings('application_name') ?? 'Machine Tool Solution')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Orders</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Order Number</th>
                                        <th>Customer Name</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($getOrders as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td><strong>{{ $order->order_number }}</strong></td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->customer_address }}</td>
                                            <td>{{ $order->customer_email }}</td>
                                            <td>{{ $order->customer_phone }}</td>
                                            <td>
                                                <div class="order-items-preview">
                                                    @forelse($order->items as $item)
                                                        <div class="d-flex align-items-center mb-1">
                                                            <img src="{{ $item->image }}" alt="{{ $item->product_name }}"
                                                                style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px; margin-right: 8px;">
                                                            <div>
                                                                <small class="d-block text-truncate"
                                                                    style="max-width: 150px;"
                                                                    title="{{ $item->product_name }}">
                                                                    {{ $item->product_name }}
                                                                </small>
                                                                <small class="text-muted">
                                                                    Qty: {{ $item->quantity }} ×
                                                                    ${{ number_format($item->price, 2) }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <span class="text-muted">No items</span>
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge @if ($order->payment_status === 'paid') badge-success @elseif($order->payment_status === 'pending') badge-warning @else badge-danger @endif">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge @if ($order->order_status === 'completed') badge-success @elseif($order->order_status === 'processing') badge-info @elseif($order->order_status === 'pending') badge-warning @else badge-danger @endif">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="btn btn-sm btn-info" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-muted py-4">
                                                <p>No orders found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .order-items-preview {
            max-height: 150px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .order-items-preview::-webkit-scrollbar {
            width: 4px;
        }

        .order-items-preview::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .order-items-preview::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .order-items-preview::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush