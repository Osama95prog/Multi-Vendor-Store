<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart as Cart2;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['category' => fn ($q) => $q->select('id','name')])->active()
        //->latest()
        ->limit(8)
        ->get();

        return view('front.home', compact('products'));
    }
}
