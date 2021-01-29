<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function products()
    {
        return view('admin.products');
    }
    public function addproduct()
    {
        $categories = Category::all()->pluck('category_name', 'category_name');
        return view('admin.addproduct')->with('categories', $categories);
    }
    public function saveproduct(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'product_price' => 'required',
            'product_image' => 'image|nullable|max:199',

        ]);
        if ($request->hasFile('product_image')) {
            // 1: get filename with ext
            $fileNameWithExt = $request->file('product_image')->getClientOriginalName();

            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // 3: get just extension
            $extension = $request->file('product_image')->getClientOriginalExtension();

            // 4 : file name to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // 5: upload image
            $path = $request->file('product_image')->storeAs('public/product_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');
        $product->product_image = $fileNameToStore;
        $product->status = 1;

        // if ($request->input('product_status')) {
        //     $product->status = 1;
        // } else {
        //     $product->status = 0;
        // }

        $product->save();
        return redirect('/addproduct')->with('status', 'The ' . $product->product_name . ' has been updated successfully');
    }
}
