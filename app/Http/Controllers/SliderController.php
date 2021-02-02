<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;

class SliderController extends Controller
{
    //
    public function sliders()
    {
        $sliders = Slider::get();
        return view('admin.sliders')->with('sliders', $sliders);
    }
    public function addslider()
    {
        return view('admin.addslider');
    }
    public function saveslider(Request $request)
    {
        $this->validate($request, [
            'description_one' => 'required',
            'description_two' => 'required',
            'product_image' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('slider_image')) {
            // 1: get filename with ext
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();

            // 2: get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // 3: get just extension
            $extension = $request->file('slider_image')->getClientOriginalExtension();

            // 4 : file name to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            // 5: upload image
            $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        $slider = new Slider();
        $slider->description1 = $request->input('description_one');
        $slider->description2 = $request->input('description_two');
        $slider->slider_image = $fileNameToStore;
        $slider->status = 1;

        $slider->save();
        return redirect('/addproduct')->with('status', 'The Slider has been saved successfully');
    }
}
