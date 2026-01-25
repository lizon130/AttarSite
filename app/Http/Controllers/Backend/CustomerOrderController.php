<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $getOrders = Order::with('user', 'items.product')->latest()->get();
        return view('backend.pages.order.index', compact('getOrders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('backend.pages.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->order_status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function invoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('backend.pages.order.invoice', compact('order'));
    }

    public function downloadInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        $pdf = Pdf::loadView('backend.pages.order.invoice-pdf', compact('order'));

        // Set paper size
        $pdf->setPaper('A4', 'portrait');

        // Download PDF with invoice name
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function printInvoice($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('backend.pages.order.invoice', compact('order'))->with('print', true);
    }
}