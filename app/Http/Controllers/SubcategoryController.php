<?php

namespace App\Http\Controllers;


use DB;
use App\Category;
use App\Subcategory;
use Illuminate\Http\Request;


class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        Category::where('id',$category_id)
//            ->with('subcategories')
//            ->get();
//
//        return response()->json([
//            'subcategories' => $subcategories
//        ]);

         $subcategories = DB::table('subcategories')
             ->join('categories','subcategories.category_id','=','categories.id')
             ->select('subcategories.*','categories.category_name')
             ->get();
         return view('admin.subcategory',
             [

                 'subcategories'=>$subcategories

             ]);
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
            'category_id'        => 'required',
            'subcategory_name' => 'required',
            'description' => 'required',
            'publication_status'   => 'required'
        ]);

        $subcategory = Subcategory::updateOrCreate(['id' => $request->id],
            [
            'category_id' =>$request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'description' => $request->description,
            'publication_status' => $request->publication_status
        ]);

        return response()->json(
            [      'code'=>200,
                'message'=>'Subcategory Created successfully',
                'data' => $subcategory
            ],
            200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
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
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id)->delete();

        return response()->json
        (
            ['success'=>'Subcategory Deleted successfully']
        );
    }
}
