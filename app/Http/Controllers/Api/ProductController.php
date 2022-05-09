<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return response(Product::paginate(10));
        $offset = $request->has('offset') ? $request->offset : 0;
        $limit = $request->has('limit') ? $request->limit : 10;

        $db = Product::query()->with('category');
        if ($request->has('q'))
            $db = $db->where('name', 'like', '%' . $request->get('q') . '%');

        if ($request->has('sortBy'))
            $db = $db->orderBy($request->get('sortBy'),$request->get('sort','DESC'));

        $data = $db->offset($offset)->limit($limit)->get();
        $data->makeHidden('slug'); // geri dönen değerde bir column gizleme
        return response($data, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $product = Product::create($input);
        return response([
            'data' => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return $this->apiResponse(ResoultType::Success,$product,'Product Found',200);
        }
        catch (ModelNotFoundException $exception){
            return $this->apiResponse(ResoultType::Error,null,'Product Not Found!',404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($request->name);
        $product->update($input);
        return response([
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response([
            'message' => 'Product deleted'
        ]);
    }

    public function report1()
    {
        $data=DB::table('category_product as cp')
            ->selectRaw('c.name, COUNT(*) as total')
            ->join('categories as c','c.id','=','cp.category_id')
            ->join('products as p','p.id','=','cp.product_id')
            ->orderByRaw('Count(*) DESC')
            ->groupBy('c.name')
            ->get();
        return $data;
    }

    public function custom1()
    {
     $products=Product::paginate(10);
     return ProductResource::collection($products);
    }

    public function listWithCategories()
    {
        $products=Product::with('category')->paginate(10);
        return ProductWithCategoriesResource::collection($products);
    }

}
