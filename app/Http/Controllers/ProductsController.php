<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsEditRequest;
use App\Http\Requests\ProductsRequest;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'active';

    public function index()
    {
        $products = Products::paginate(10);
        return view('products.index', ["products"=>$products, 'page_product'=>$this->page]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view('products.create', ['page_product'=>$this->page, 'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        $product = new Products();
        $product->name = $request->name;
        $image = $request->file('image');
        $random = $this->setRandom();
        $product_image_name = $random.''.date('Y-m-dh-i-s').'.'.$image->extension();
        $image->storeAs('public/products/', $product_image_name);
        $product->image = $product_image_name;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('products.index')->with('status', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Products::find($id);
        return view('products.show', ["product"=>$product, 'page_product'=>$this->page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Categories::all();
        $product = Products::find($id);
        return view('products.edit', ["product"=>$product, 'page_product'=>$this->page, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsEditRequest $request, string $id)
    {
        $product = Products::find($id);
        $product->name = $request->name;
        if($request->image){
            if($product->image){
                if(str_replace(' ', '', $product->image) != ''){
                    $avatar_main = storage_path('app/public/products/'.$product->image);
                    if(file_exists($avatar_main)){
                        unlink($avatar_main);
                    }
                }
            }
            $image = $request->file('image');
            $random = $this->setRandom();
            $product_image_name = $random.''.date('Y-m-dh-i-s').'.'.$image->extension();
            $image->storeAs('public/products/', $product_image_name);
            $product->image = $product_image_name;
        }
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->save();
        return redirect()->route('products.index')->with('status', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        if($product->image){
            if(str_replace(' ', '', $product->image) != ''){
                $avatar_main = storage_path('app/public/products/'.$product->image);
                if(file_exists($avatar_main)){
                    unlink($avatar_main);
                }
            }
        }
        $product->delete();
        return redirect()->route('products.index')->with('status', 'Successfully deleted');
    }
}
