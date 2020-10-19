<?php

namespace App\Http\Controllers;
use DB;
use App\Category;
use App\Product;
use App\Subcategory;
use App\Brand;
use Illuminate\Http\Request;

class ProductssssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $products = DB::table('products')
                ->join('categories','products.category_id','=','categories.id')
                ->join('brands','products.brand_id','=','brands.id')
                ->select('products.*','categories.category_name',
                    'brands.brand_name')->get();
      return  view('admin.produts',['products'=>$products]);
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
        $request->validate([
            'category_id'    =>  'required',
            'brand_id' => 'required',
            'product_name' => 'required',
            'product_size' => 'required',
            'product_color' => 'required',
            'product_price' => 'required',
            'product_quantity' => 'required',
            'product_short_description'     =>  'required',
            'product_long_description'      =>   'required',
            'product_image'         =>  'required|image|max:2048',
            'publication_status'  => 'required'
        ]);


        $image = $request->file('product_image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('product-images'), $new_name);

        $form_data = array(
            'category_id'      => $request->category_id,
            'brand_id'         => $request->brand_id,
            'product_name'     => $request->product_name,
            'product_size'     => $request->product_size,
            'product_color'    => $request->product_color,
            'product_price'    => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'product_image'             =>  $new_name,
            'publication_status'      => $request->publication_status
        );

  $product =  Product::create($form_data);

        return response()->json(['product'=>$product,
            'success' => 'Product Added successfully.']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $image_name = $request->hidden_image;
        $image = $request->file('product_image');
        if($image != '')
        {
            $request->validate([
                'category_id'    =>  'required',
                'brand_id'         =>  'required',
                'product_name'  => 'required',
                'product_price'  => 'required',
                'product_color'  => 'required',
                'product_size'  => 'required',
                'product_quantity'  => 'required',
                'product_short_description' => 'required',
                'product_long_description' => 'required',
                'product_image'=> 'required',
                'publication_status' => 'required'
            ]);


            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product-images'), $image_name);
        }
        else
        {
            $request->validate([
                'category_id'    =>  'required',
                'brand_id'         =>  'required',
                'product_name'  => 'required',
                'product_price'  => 'required',
                'product_color'  => 'required',
                'product_size'  => 'required',
                'product_quantity'  => 'required',
                'product_short_description' => 'required',
                'product_long_description' => 'required',
                'publication_status' => 'required'
            ]);
        }

        $form_data = array(
            'category_id'      =>  $request->category_id,
            'brnad_id'         => $request->brand_id,
            'product_name'     => $request->product_name,
            'product_size'     => $request->product_size,
            'product_color'    => $request->product_color,
            'product_price'    => $request->product_price,
            'product_quantity' => $request->product_quantity,
            'product_short_description' => $request->product_short_description,
            'product_long_description' => $request->product_long_description,
            'product_image'             =>  $image_name,
            'publication_status'      => $request->publication_status
        );
     $product =    Product::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Product is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
    }
}
