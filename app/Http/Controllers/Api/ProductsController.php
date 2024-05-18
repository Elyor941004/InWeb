<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsEditRequest;
use App\Http\Requests\ProductsRequest;
use App\Models\Categories;
use App\Models\Pages;
use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="All Products",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="indexProducts",
     *     @OA\Parameter(
     *         name="products",
     *         in="query",
     *         description="All Products",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *      security={
     *         {"bearer_token": {}}
     *     },
     * )
     */
    public function indexProducts()
    {
        $products = Products::all();
        $response = [
            'data'=>$products,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/products/1",
     *     tags={"Products"},
     *     summary="Get products by id",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="showProducts",
     *     @OA\Parameter(
     *         name="products",
     *         in="query",
     *         description="Get product by id",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *      security={
     *         {"bearer_token": {}}
     *     },
     * )
     */
    public function showProducts($id)
    {
        $page = Products::find($id);
        $response = [
            'data'=>$page,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products/store",
     *     tags={"Products"},
     *     summary="Create products",
     *     operationId="storeProducts",

     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Enter name of the category",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     description="Enter category image",
     *                     type="file"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="Enter category title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     description="Enter category id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Enter category description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function storeProducts(ProductsRequest $request)
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
        $response = [
            'message'=>'Successfully created',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/products/update/1",
     *     tags={"Products"},
     *     summary="Update product",
     *     operationId="updateProducts",

     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     },
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Enter name of the category",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     description="Enter category image",
     *                     type="file"
     *                 ),
     *                 @OA\Property(
     *                     property="category_id",
     *                     description="Enter category id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="Enter category title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Enter category description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateProducts(ProductsEditRequest $request, string $id)
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
        $response = [
            'message'=>'Successfully updated',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/products/destroy/1",
     *     tags={"Products"},
     *     summary="delete product",
     *     operationId="destroyProducts",

     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function destroyProducts(string $id)
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
        $response = [
            'message'=>'Successfully deleted',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }
}
