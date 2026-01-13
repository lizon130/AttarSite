<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {  
        return view('frontend.home.index');
    }
    public function product()
    {  
        return view('frontend.home.product');
    }
    public function productDetails()
    {  
        return view('frontend.home.product_details');
    }
    public function cart()
    {  
        return view('frontend.home.cart');
    }
}
