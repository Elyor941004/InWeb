<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesEditRequest;
use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'active';

    public function index()
    {
        $categories = Categories::paginate(5);
        return view('categories.index', ["categories"=>$categories, 'page_category'=>$this->page]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create', ['page_category'=>$this->page]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        $category = new Categories();
        $category->name = $request->name;
        $image = $request->file('image');
        $random = $this->setRandom();
        $product_image_name = $random.''.date('Y-m-dh-i-s').'.'.$image->extension();
        $image->storeAs('public/categories/', $product_image_name);
        $category->image = $product_image_name;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('categories.index')->with('status', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Categories::find($id);
        return view('categories.edit', ["category"=>$category, 'page_category'=>$this->page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesEditRequest $request, string $id)
    {
        $category = Categories::find($id);
        $category->name = $request->name;
        if($request->image){
            if($category->image){
                if(str_replace(' ', '', $category->image) != ''){
                    $avatar_main = storage_path('app/public/categories/'.$category->image);
                    if(file_exists($avatar_main)){
                        unlink($avatar_main);
                    }
                }
            }
            $image = $request->file('image');
            $random = $this->setRandom();
            $product_image_name = $random.''.date('Y-m-dh-i-s').'.'.$image->extension();
            $image->storeAs('public/categories/', $product_image_name);
            $category->image = $product_image_name;
        }
        $category->title = $request->title;
        $category->description = $request->description;
        $category->save();
        return redirect()->route('categories.index')->with('status', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::find($id);
        if($category->image){
            if(str_replace(' ', '', $category->image) != ''){
                $avatar_main = storage_path('app/public/categories/'.$category->image);
                if(file_exists($avatar_main)){
                    unlink($avatar_main);
                }
            }
        }
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Successfully deleted');
    }
}
