<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function addcategory()
    {
        return view('admin.addcategory');
    }

    public function categories()
    {
        $categories=Category::get();
        return view('admin.categories')->with('categories', $categories);
    }
    public function savecategory(Request $request){
        $checkcat=Category::where('category_name',$request->input('category_name'))->first();
        $category=new Category();
        if(!$checkcat){
            $category->category_name=$request->input('category_name');
            $category->save();
            return redirect('/addcategory')->with('status','The '.$category->category_name.'Category has been saved successfully');
        }
        else{
            return redirect('/addcategory')->with('status1','The '.$category->category_name.'Category already exists');
        }
    }
}
