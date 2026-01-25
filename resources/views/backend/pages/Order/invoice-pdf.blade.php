{{-- resources/views/backend/pages/order/invoice-pdf.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        /* Ultra Compact Invoice Design with Signatures */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
            padding: 10px;
            background: #fff;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 5px;
        }
        
        /* Header - Super Compact */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #0f3d28;
        }
        
        .company-info {
            flex: 2;
        }
        
        .company-name {
            font-size: 14px;
            font-weight: bold;
            color: #0f3d28;
            margin-bottom: 2px;
        }
        
        .company-address {
            font-size: 8px;
            color: #555;
            line-height: 1.1;
        }
        
        .invoice-title {
            text-align: right;
            flex: 1;
        }
        
        .invoice-title h1 {
            font-size: 18px;
            color: #0f3d28;
            margin-bottom: 2px;
            font-weight: bold;
        }
        
        .invoice-meta {
            font-size: 9px;
            color: #555;
        }
        
        /* Customer & Invoice Details - Side by side boxes */
        .details-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            gap: 10px;
        }
        
        .details-box {
            flex: 1;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 3px;
            background: #f9f9f9;
            min-height: 90px;
        }
        
        .details-title {
            font-size: 9px;
            font-weight: bold;
            color: #0f3d28;
            margin-bottom: 4px;
            padding-bottom: 2px;
            border-bottom: 1px solid #ddd;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 2px;
            font-size: 8px;
        }
        
        .detail-label {
            font-weight: bold;
            min-width: 55px;
        }
        
        .detail-value {
            flex: 1;
        }
        
        /* Items Table - Ultra Compact */
        .items-section {
            margin: 8px 0;
        }
        
        .items-title {
            font-size: 9px;
            font-weight: bold;
            color: #0f3d28;
            margin-bottom: 3px;
            padding-bottom: 2px;
            border-bottom: 1px solid #ddd;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        
        .items-table th {
            background: #0f3d28;
            color: white;
            padding: 4px 3px;
            text-align: left;
            font-weight: bold;
            border: none;
        }
        
        .items-table td {
            padding: 4px 3px;
            border-bottom: 1px solid #eee;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Totals - Compact */
        .totals-section {
            margin-top: 8px;
            margin-left: auto;
            width: 250px;
        }
        
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        
        .totals-table td {
            padding: 4px 5px;
            border-bottom: 1px solid #eee;
        }
        
        .total-label {
            font-weight: bold;
            text-align: right;
        }
        
        .total-value {
            text-align: right;
            font-weight: 500;
        }
        
        .grand-total {
            font-weight: bold;
            color: #0f3d28;
            background: #f0f0f0;
            font-size: 10px;
        }
        
        /* Signature Section */
        .signature-section {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        
        .signature-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        
        .signature-box {
            flex: 1;
            text-align: center;
            padding: 8px;
            border-top: 1px solid #000;
            margin-top: 25px;
        }
        
        .signature-label {
            font-size: 9px;
            font-weight: bold;
            color: #0f3d28;
            margin-bottom: 5px;
        }
        
        .signature-name {
            font-size: 10px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .signature-position {
            font-size: 8px;
            color: #666;
            font-style: italic;
        }
        
        .signature-line {
            height: 1px;
            background: #000;
            margin: 15px 0 5px;
        }
        
        /* Footer - Compact */
        .invoice-footer {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #ddd;
            font-size: 8px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 5px;
        }
        
        .footer-box {
            padding: 3px;
            border: 1px solid #eee;
            border-radius: 2px;
            background: #f9f9f9;
        }
        
        .footer-title {
            font-size: 8px;
            font-weight: bold;
            color: #0f3d28;
            margin-bottom: 2px;
        }
        
        .footer-content {
            line-height: 1.1;
            color: #555;
        }
        
        .stamp-container {
            text-align: center;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px dashed #ccc;
        }
        
        .stamp {
            display: inline-block;
            padding: 3px 15px;
            background: #0f3d28;
            color: white;
            font-weight: bold;
            font-size: 9px;
            border-radius: 2px;
        }
        
        /* Print optimizations */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            
            .invoice-container {
                padding: 3px;
                max-width: 100%;
            }
            
            .signature-box {
                border-top: 1px solid #000 !important;
            }
        }
        
        /* Prevent page breaks */
        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="invoice-container no-break">
        <!-- Header -->
        <div class="invoice-header no-break">
            <div class="company-info">
                <div class="company-name">{{ Helper::getSettings('application_name') ?? 'Al-Noor Trading' }}</div>
                <div class="company-address">
                    {{ Helper::getSettings('company_address') ?? '123 Business St, City' }}<br>
                    📞 {{ Helper::getSettings('company_phone') ?? '+1 234 567 890' }} | 
                    ✉ {{ Helper::getSettings('company_email') ?? 'info@company.com' }}
                </div>
            </div>
            
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <div class="invoice-meta">
                    <strong>#{{ $order->order_number }}</strong><br>
                    {{ $order->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>
        
        <!-- Customer & Invoice Details - Side by side boxes -->
        <div class="details-container no-break">
            <!-- BILL TO Box -->
            <div class="details-box">
                <div class="details-title">BILL TO</div>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value">{{ $order->customer_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $order->customer_email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $order->customer_phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value">{{ $order->customer_address }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">City:</span>
                    <span class="detail-value">{{ $order->city }}, {{ $order->state }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">ZIP:</span>
                    <span class="detail-value">{{ $order->zip_code }}, {{ $order->country }}</span>
                </div>
            </div>
            
            <!-- INVOICE DETAILS Box -->
            <div class="details-box">
                <div class="details-title">INVOICE DETAILS</div>
                <div class="detail-row">
                    <span class="detail-label">Invoice #:</span>
                    <span class="detail-value">{{ $order->order_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Due Date:</span>
                    <span class="detail-value">{{ $order->created_at->addDays(7)->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment:</span>
                    <span class="detail-value">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">{{ ucfirst($order->order_status) }}</span>
                </div>
                @if($order->special_instructions)
                <div class="detail-row">
                    <span class="detail-label">Notes:</span>
                    <span class="detail-value">{{ Str::limit($order->special_instructions, 50) }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Items Table -->
        <div class="items-section no-break">
            <div class="items-title">ORDER ITEMS</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="55%">PRODUCT DESCRIPTION</th>
                        <th width="15%" class="text-right">UNIT PRICE</th>
                        <th width="10%" class="text-center">QTY</th>
                        <th width="15%" class="text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Totals -->
        <div class="totals-section no-break">
            <table class="totals-table">
                <tr>
                    <td class="total-label">Subtotal:</td>
                    <td class="total-value">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td class="total-label">Tax (10%):</td>
                    <td class="total-value">${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td class="total-label">Shipping:</td>
                    <td class="total-value">
                        @if($order->shipping > 0)
                            ${{ number_format($order->shipping, 2) }}
                        @else
                            Free
                        @endif
                    </td>
                </tr>
                <tr class="grand-total">
                    <td class="total-label">TOTAL AMOUNT:</td>
                    <td class="total-value">${{ number_format($order->total, 2) }}</td>
                </tr>
                @if($order->payment_method == 'cod')
                <tr>
                    <td class="total-label">Amount Due:</td>
                    <td class="total-value">${{ number_format($order->total, 2) }}</td>
                </tr>
                @endif
            </table>
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section no-break">
            <div class="signature-container">
                <!-- Left: Company Signature -->
                <div class="signature-box" style="text-align: left;">
                    <div class="signature-label">FOR {{ Helper::getSettings('application_name') ?? 'AL-NOOR TRADING' }}</div>
                    <div class="signature-line"></div>
                    <div class="signature-name">Arman Lizon</div>
                    <div class="signature-position">Owner, LAS Digital Solution</div>
                    <div style="font-size: 7px; color: #666; margin-top: 3px;">
                        Date: ________________
                    </div>
                </div>
                
                <!-- Right: Customer Signature -->
                <div class="signature-box" style="text-align: right;">
                    <div class="signature-label">CUSTOMER ACKNOWLEDGEMENT</div>
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $order->customer_name }}</div>
                    <div class="signature-position">Customer</div>
                    <div style="font-size: 7px; color: #666; margin-top: 3px;">
                        Date: ________________
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; font-size: 7px; color: #777; margin-top: 10px; font-style: italic;">
                This invoice is computer generated and does not require a physical signature.
            </div>
        </div>
        
        <!-- Footer -->
        <div class="invoice-footer no-break">
            <div class="footer-grid">
                <div class="footer-box">
                    <div class="footer-title">PAYMENT TERMS</div>
                    <div class="footer-content">
                        @if($order->payment_method == 'cod')
                            Payment due upon delivery<br>
                            Cash on delivery only
                        @else
                            Payment completed online<br>
                            Thank you for your payment
                        @endif
                    </div>
                </div>
                
                <div class="footer-box">
                    <div class="footer-title">SHIPPING INFO</div>
                    <div class="footer-content">
                        3-5 business days delivery<br>
                        Standard shipping included<br>
                        Tracking provided via email
                    </div>
                </div>
                
                <div class="footer-box">
                    <div class="footer-title">CONTACT US</div>
                    <div class="footer-content">
                        {{ Helper::getSettings('company_email') ?? 'info@company.com' }}<br>
                        {{ Helper::getSettings('company_phone') ?? '+1 234 567 890' }}<br>
                        Mon-Fri 9AM-6PM
                    </div>
                </div>
            </div>
            
            <div class="stamp-container">
                <div class="stamp">
                    {{ $order->payment_status === 'paid' ? 'PAID' : 'UNPAID' }}
                </div>
                <div style="font-size: 7px; color: #777; margin-top: 2px;">
                    Invoice generated: {{ now()->format('M d, Y H:i') }} | Valid through: {{ $order->created_at->addDays(30)->format('M d, Y') }}
                </div>
            </div>
            
            <!-- Thank you note -->
            <div style="text-align: center; margin-top: 5px; font-size: 8px; color: #0f3d28; font-weight: bold;">
                Thank you for choosing {{ Helper::getSettings('application_name') ?? 'Al-Noor Trading' }}!
            </div>
        </div>
    </div>
</body>
</html>