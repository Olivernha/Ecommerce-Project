<?php

namespace App\Http\Controllers;

use App\Slider;
use App\Product;
use App\Category;
use App\Cart;
use App\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Support\Facades\DB;

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
        if (!Session::has('cart')) {
            return view('client.cart');
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        return view('client.cart', ['products' => $cart->items]);
    }
    public function updateqty(Request $reqeust)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->updateQty($reqeust->id, $reqeust->quantity);
        Session::put('cart', $cart);
        return redirect('/cart');
    }
    public function removeitem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }

        return redirect('/cart');
    }
    public function shop()
    {
        $categories = Category::get();
        $products = Product::get();
        return view('client.shop', compact('products', 'categories'));
    }
    public function checkout()
    {
        if (!Session::has('cart')) {
            return redirect('/cart');
        }
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
    public function postcheckout(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect('/cart');
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        Stripe::setApiKey('sk_test_51IGhxCEpyNpaHrYFwiCuw7hsa3wMRDJLcutiFs99onniLhKL54RmkIyAeXNFvffju9fp1rrPmRU88MJgo7he6R4J00bd78NylE');
        try {
            $charge=Charge::create(array(
                "amount" => Session::get('cart')->totalPrice * 100,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtainded with Stripe.js
                "description" => "Test Charge"
            ));
            $order=new Order();
            $order->name=$request->input('name');
            $order->address=$request->input('address');
            $order->cart=serialize($cart);
            $order->payment_id= $charge->id;
            $order->save();

        } catch (\Exception $e) {
            Session::put('error', $e->getMessage());
            return redirect('/checkout');
        }

        Session::forget('cart');
        return redirect('/cart')->with('success', 'Purchase accomplished successfully !');
    }
}
