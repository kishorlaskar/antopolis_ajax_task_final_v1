<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Validator;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::get();
        return view('admin.brand.index',compact('brands'));
    }

    public function get()
    {
        $brands = Brand::get();
        return view('admin.brand.brand_list',compact('brands'));
    }
    public function store(Request $request)
    {
        $brand = new Brand();
        $brand_image = $request->file('brand_image');
        $new_name = rand().'-'.$brand_image->getClientOriginalName();
        $brand_image->move(public_path('Upload/Brand/'),$new_name);
        $brand->brand_name = $request->brand_name;
        $brand->brand_description = $request->brand_description;
        $brand->brand_image = $new_name;
        $brand->publication_status = $request->publication_status;
        $data = $brand->save();
        return response()->json($data);

    }
    public function edit(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        return response($brand);
    }
    public function update(Request $request)
    {
        $old_image = $request->old_image;
        if($brand_image = $request->file('brand_image')){
            $new_name = rand().'-'.$brand_image->getClientOriginalName();
            $brand_image->move(public_path('upload/brand/'),$new_name);
            File::delete(public_path('upload/brand/'.$old_image));
        } else {
            $new_name = $old_image;
        }
        $form_data = array(
            'brand_name' => $request->brand_name,
            'brand_description' =>$request->brand_description,
            'brand_image' => $new_name
        );
        $output = Brand::findOrFail($request->brand_id)->update($form_data);

        return response(Brand::findOrFail($request->brand_id));
    }
    public function destroy(Request $request)
    {

        $brand = Brand::findOrFail($request->id);
        File::delete(public_path('upload/brand/'.$brand->brand_image));
       $dt  = $brand->delete();

            return response($dt);
        }

    }





