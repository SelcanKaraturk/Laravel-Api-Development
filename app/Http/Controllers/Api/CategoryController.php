<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->name);
        $category = Category::create($input);
        return response([
            'data' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input=$request->all();
        $input['slug']=Str::slug($request->name);
        $category->update($input);
        return response([
            'data'=>$category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response([
            'message'=>'Category deleted'
        ]);
    }

    public function custom1()
    {
        //$data=Category::pluck('name','id');
        //$data=Category::select('id','name')->take(5)->get();
        $data=Category::selectRaw('id as category_id','name as category_name')->get();
        return $data;
    }

    public function custom2()
    {
        $data=Category::all();
        $mapping=$data->map(function ($data){
            return [
                '_id'=>$data['id'],
                'category_name'=>$data['name']
            ];
        });
        return $mapping;
    }

}
