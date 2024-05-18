<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesEditRequest;
use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;

class CategoriesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="All Categories",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="indexCategories",
     *     @OA\Parameter(
     *         name="products",
     *         in="query",
     *         description="All categories",
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
    public function indexCategories()
    {
        $categories = Categories::all();
        $response = [
            'data'=>$categories,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/1",
     *     tags={"Categories"},
     *     summary="Get category by id",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="showCategories",
     *     @OA\Parameter(
     *         name="categoris",
     *         in="query",
     *         description="Get category by id",
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
    public function showCategories($id)
    {
        $category = Categories::find($id);
        $response = [
            'data'=>$category,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories/store",
     *     tags={"Categories"},
     *     summary="Create categories",
     *     operationId="storeCategories",

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
     *                     property="description",
     *                     description="Enter category description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function storeCategories(CategoriesRequest $request)
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
        $response = [
            'message'=>'Successfully added',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories/update/1",
     *     tags={"Categories"},
     *     summary="Update category",
     *     operationId="updateCategories",

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
     *                     property="description",
     *                     description="Enter category description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updateCategories(CategoriesEditRequest $request, string $id)
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
        $response = [
            'message'=>'Successfully updated',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categories/destroy/1",
     *     tags={"Categories"},
     *     summary="delete category",
     *     operationId="destroyCategories",

     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function destroyCategories(string $id)
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
        $response = [
            'message'=>'Successfully deleted',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }
}
