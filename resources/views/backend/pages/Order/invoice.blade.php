{{-- resources/views/backend/pages/order/invoice.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        /* Invoice Styles */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            color: #333;
            padding: 20px;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0f3d28;
        }

        .company-info h2 {
            color: #0f3d28;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .company-info p {
            color: #666;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .invoice-title h1 {
            color: #0f3d28;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .invoice-title p {
            color: #666;
            font-size: 14px;
        }

        /* Invoice Details */
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 30px;
        }

        .bill-to,
        .invoice-info {
            flex: 1;
        }

        .section-title {
            color: #0f3d28;
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .info-group {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .info-value {
            color: #333;
            font-size: 15px;
        }

        /* Items Table */
        .invoice-items {
            margin-bottom: 40px;
            overflow-x: auto;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead {
            background: #0f3d28;
            color: white;
        }

        .items-table th {
            padding: 15px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #eee;
        }

        .items-table tbody tr:hover {
            background: #f9f9f9;
        }

        .items-table td {
            padding: 15px;
            font-size: 14px;
        }

        .item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        /* Summary */
        .invoice-summary {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .summary-table {
            width: 300px;
            border-collapse: collapse;
        }

        .summary-table tr {
            border-bottom: 1px solid #eee;
        }

        .summary-table td {
            padding: 12px 15px;
            font-size: 15px;
        }

        .summary-table tr:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #555;
            text-align: right;
        }

        .summary-value {
            text-align: right;
            font-weight: 500;
        }

        .total-row {
            background: #f8f9fa;
            font-weight: 600;
            color: #0f3d28;
            font-size: 16px;
        }

        /* Footer */
        .invoice-footer {
            border-top: 2px solid #eee;
            padding-top: 30px;
            margin-top: 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            color: #0f3d28;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .footer-section p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-stamp {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px dashed #ccc;
        }

        .stamp {
            display: inline-block;
            padding: 10px 30px;
            background: #0f3d28;
            color: white;
            border-radius: 5px;
            font-weight: 500;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                padding: 20px;
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }

            .invoice-header {
                margin-bottom: 30px;
            }

            .items-table th,
            .items-table td {
                padding: 10px;
                font-size: 12px;
            }
        }

        /* Action Buttons */
        .action-buttons {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-print {
            background: #0f3d28;
            color: white;
        }

        .btn-print:hover {
            background: #0a2d1c;
        }

        .btn-download {
            background: #28a745;
            color: white;
        }

        .btn-download:hover {
            background: #218838;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h2>{{ Helper::getSettings('application_name') ?? 'Al-Noor' }}</h2>
                <p>{{ Helper::getSettings('company_address') ?? '123 Business Street, City, Country' }}</p>
                <p>Phone: {{ Helper::getSettings('company_phone') ?? '+1 234 567 890' }}</p>
                <p>Email: {{ Helper::getSettings('company_email') ?? 'info@company.com' }}</p>
                <p>Website: {{ Helper::getSettings('website') ?? 'www.company.com' }}</p>
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>Invoice #{{ $order->order_number }}</p>
                <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="bill-to">
                <h3 class="section-title">Bill To</h3>
                <div class="info-group">
                    <div class="info-label">Customer Name</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email Address</div>
                    <div class="info-value">{{ $order->customer_email }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $order->customer_phone }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Shipping Address</div>
                    <div class="info-value">
                        {{ $order->customer_address }}<br>
                        {{ $order->city }}, {{ $order->state }}<br>
                        {{ $order->zip_code }}, {{ $order->country }}
                    </div>
                </div>
            </div>
            <div class="invoice-info">
                <h3 class="section-title">Invoice Details</h3>
                <div class="info-group">
                    <div class="info-label">Invoice Number</div>
                    <div class="info-value">{{ $order->order_number }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Invoice Date</div>
                    <div class="info-value">{{ $order->created_at->format('F d, Y') }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Payment Method</div>
                    <div class="info-value">{{ strtoupper($order->payment_method) }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Payment Status</div>
                    <div class="info-value">
                        <span
                            style="color: {{ $order->payment_status === 'paid' ? '#28a745' : ($order->payment_status === 'pending' ? '#ffc107' : '#dc3545') }};">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-label">Order Status</div>
                    <div class="info-value">
                        <span
                            style="color: {{ $order->order_status === 'completed' ? '#28a745' : ($order->order_status === 'processing' ? '#17a2b8' : ($order->order_status === 'pending' ? '#ffc107' : '#dc3545')) }};">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                </div>
                @if ($order->special_instructions)
                    <div class="info-group">
                        <div class="info-label">Special Instructions</div>
                        <div class="info-value">{{ $order->special_instructions }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="invoice-items">
            <h3 class="section-title">Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <img src="{{ $item->image }}" alt="{{ $item->product_name }}" class="item-image">
                            </td>
                            <td>{{ $item->product_name }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="invoice-summary">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">Subtotal:</td>
                    <td class="summary-value">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Tax (10%):</td>
                    <td class="summary-value">${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td class="summary-label">Shipping:</td>
                    <td class="summary-value">
                        @if ($order->shipping > 0)
                            ${{ number_format($order->shipping, 2) }}
                        @else
                            <span style="color: #28a745;">Free</span>
                        @endif
                    </td>
                </tr>
                <tr class="total-row">
                    <td class="summary-label">Total Amount:</td>
                    <td class="summary-value">${{ number_format($order->total, 2) }}</td>
                </tr>
                @if ($order->payment_method == 'cod')
                    <tr>
                        <td class="summary-label">Payment Due:</td>
                        <td class="summary-value" style="color: #dc3545; font-weight: 600;">
                            ${{ number_format($order->total, 2) }}
                        </td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>Payment Terms</h4>
                    <p>
                        @if ($order->payment_method == 'cod')
                            Payment due on delivery. Please have exact amount ready.
                        @else
                            Payment completed online. Thank you for your payment.
                        @endif
                    </p>
                </div>
                <div class="footer-section">
                    <h4>Shipping Info</h4>
                    <p>
                        Standard Shipping<br>
                        Estimated Delivery: 3-5 Business Days<br>
                        Shipping Method: Standard Ground
                    </p>
                </div>
                <div class="footer-section">
                    <h4>Thank You</h4>
                    <p>
                        Thank you for your business. We appreciate your trust in our products and services.
                    </p>
                </div>
            </div>

            <div class="invoice-stamp">
                <div class="stamp">
                    {{ $order->payment_status === 'paid' ? 'PAID' : 'UNPAID' }}
                </div>
            </div>
        </div>

        <!-- Action Buttons (Not printed) -->
        <div class="action-buttons no-print">
            <button class="btn btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Print Invoice
            </button>
            <a href="{{ route('admin.orders.download-invoice', $order->id) }}" class="btn btn-download">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Order
            </a>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        // Auto print if needed
        @if (request()->has('print'))
            window.onload = function() {
                window.print();
            }
        @endif
    </script>
</body>
</html>