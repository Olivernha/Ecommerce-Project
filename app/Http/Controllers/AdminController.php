<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function addcategory()
    {
        return view('admin.addcategory');
    }

    public function categories()
    {
        return view('admin.categories');
    }
    public function orders()
    {
        return view('admin.orders');
    }
}
