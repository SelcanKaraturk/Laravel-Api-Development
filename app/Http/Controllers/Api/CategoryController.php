<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //App::setLocale('tr');
        $locale = App::currentLocale();
        return $locale;
        return $this->apiResponse(ResoultType::Success,Category::all(),'Categoriler Çekildi',200);
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
        return $this->apiResponse($category,'Categoriler oluşturuldu',200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->apiResponse($category,'Categorileri çekildi',200);
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
        return $this->apiResponse($category,'Categorileri güncellendi',200);

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
        return $this->apiResponse(null,'Categorileri silindi',200);

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
