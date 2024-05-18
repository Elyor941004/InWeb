<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagesRequest;
use App\Models\Categories;
use App\Models\Pages;

class PagesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pages",
     *     tags={"Pages"},
     *     summary="All Pages",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="indexPages",
     *     @OA\Parameter(
     *         name="pages",
     *         in="query",
     *         description="All pages",
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
    public function indexPages()
    {
        $pages = Pages::all();
        $response = [
            'data'=>$pages,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/pages/1",
     *     tags={"Pages"},
     *     summary="Get pages by id",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="showPages",
     *     @OA\Parameter(
     *         name="pages",
     *         in="query",
     *         description="Get page by id",
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
    public function showPages($id)
    {
        $pages = Pages::find($id);
        $response = [
            'data'=>$pages,
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pages/store",
     *     tags={"Pages"},
     *     summary="Create pages",
     *     operationId="storePages",

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
    public function storePages(PagesRequest $request)
    {
        $page = new Pages();
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->save();
        $response = [
            'message'=>'Successfully created',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/pages/update/1",
     *     tags={"Pages"},
     *     summary="Update pages",
     *     operationId="updatePages",

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
     *                     description="Enter name of the page",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     description="Enter page title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Enter page description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function updatePages(PagesRequest $request, string $id)
    {
        $page = Pages::find($id);
        $page->name = $request->name;
        $page->title = $request->title;
        $page->description = $request->description;
        $page->save();
        $response = [
            'message'=>'Successfully updated',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/page/destroy/1",
     *     tags={"Pages"},
     *     summary="delete page",
     *     operationId="destroyPages",

     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function destroyPages(string $id)
    {
        $page = Pages::find($id);
        $page->delete();
        $response = [
            'message'=>'Successfully deleted',
            'status'=>true,
        ];
        return response()->json($response, 200);
    }
}
