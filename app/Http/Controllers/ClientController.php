<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function home()
    {
        $products = Product::get();
        $sliders = Slider::get();
        return view('client.home', compact('sliders', 'products'));
    }
    public function cart()
    {
        return view('client.cart');
    }
    public function shop()
    {
        $categories = Category::get();
        $products = Product::get();
        return view('client.shop', compact('products', 'categories'));
    }
    public function checkout()
    {
        return view('client.checkout');
    }
    public function login()
    {
        return view('client.login');
    }
    public function signup()
    {
        return view('client.signup');
    }
}
