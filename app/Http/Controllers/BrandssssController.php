<?php

namespace App\Http\Controllers;

use App\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
class BrandssssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::get();
        return view('admin.brand.index',compact('brands'));
    }

    public function get()
    {
        $brands = Brand::get();
        return view('admin.brand.cat_list',compact('brand'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand = new Brand();

        $brand_image = $request->file('brand_image');
        $new_name = rand().'-'.$brand_image->getClientOriginalName();
        $brand_image->move(public_path('Upload/Brand/'),$new_name);
        $brand->brand_name = $request->brand_name;
        $brand->brand_description = $request->brand_description;
        $brand->brand_image = $new_name;
        if($brand->save()){
            \LogActivity::addToLog('Brand Added.');
            return "Successful";
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        return response($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $old_image = $request->old_image;
        if($brand_image = $request->file('image')){
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
        \LogActivity::addToLog('Brand Updated Successfully.');
        return response(Category::findOrFail($request->cat_id));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $brand = Brand::findOrFail($request->id);
        File::delete(public_path('upload/brand/'.$brand->brand_image));
        if($brand->delete()){
            \LogActivity::addToLog('Brand Deleted Succesfully.');
            return response($brand);
        }

    }

}
