<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Subcategory;
use App\Brand;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->join('subcategories','products.subcategory_id','=','subcategories.id')
            ->join('brands','products.brand_id','=','brands.id')
            ->select('products.*','categories.category_name', 'subcategories.subcategory_name',
                'brands.brand_name')->get();
        return view('admin.product.index',compact('products'));
    }

    public function get()
    {

        $products = DB::table('products')
            ->join('categories','products.category_id','=','categories.id')
            ->join('subcategories','products.subcategory_id','=','subcategories.id')
            ->join('brands','products.brand_id','=','brands.id')
            ->select('products.*','categories.category_name', 'subcategories.subcategory_name',
                'brands.brand_name')->get();

        return view('admin.product.product_list',compact('products'));
    }
    public function store(Request $request)
    {
        $product = new Product();
        $product_image = $request->file('product_image');
        $new_name = rand().'-'.$product_image->getClientOriginalName();
        $product_image->move(public_path('Upload/Product/'),$new_name);
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->product_name = $request->product_name;
        $product->product_size = $request->product_size;
        $product->product_color = $request->product_color;
        $product->product_price = $request->product_price;
        $product->product_quantity = $request->product_quantity;
        $product->product_short_description = $request->product_short_description;
        $product->product_long_description = $request->product_long_description;
        $product->product_image = $new_name;
        $product->publication_status = $request->publication_status;
        $data = $product->save();
        return response()->json($data);

    }
    public function edit(Request $request)
    {
        $product = Product::findOrFail($request->id);
        return response($product);
    }
    public function update(Request $request)
    {
        $old_image = $request->old_image;
        if($product_image = $request->file('product_image')){
            $new_name = rand().'-'.$product_image->getClientOriginalName();
            $product_image->move(public_path('upload/product/'),$new_name);
            File::delete(public_path('upload/product/'.$old_image));
        } else {
            $new_name = $old_image;
        }
        $form_data = array(
            'category_id' => $request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'brand_id'=>$request->brand_id,
            'product_name'=>$request->product_name,
            'product_size'=>$request->product_size,
            'product_color'=>$request->product_color,
            'product_price'=>$request->product_price,
            'product_quantity'=>$request->product_quantity,
            'product_short_description'=>$request->product_short_description,
            'product_long_description'=>$request->product_long_description,
            'product_image' => $new_name,
            'publication_status'=>$request->publication_status
        );
        $output = Product::findOrFail($request->product_id)->update($form_data);

        return response(Product::findOrFail($request->product_id));
    }
    public function destroy(Request $request)
    {

        $product = Product::findOrFail($request->id);
        File::delete(public_path('upload/product/'.$product->product_image));
        $dt  = $product->delete();
        return response($dt);
    }

}
