<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $getOrders = Order::with('user', 'items')->latest()->get();
        return view('backend.pages.order.index', compact('getOrders'));
    }
}
