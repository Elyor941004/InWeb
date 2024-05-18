<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      x={
     *          "logo": {
     *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
     *          }
     *      },
     *      title="L5 OpenApi",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="darius@matulionis.lt"
     *      ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     *  @OA\Server(
     *     description="SwaggerHUB API Mocking",
     *     url="http://127.0.0.1:8000"
     * )
     */


    use AuthorizesRequests, ValidatesRequests;

    public function setRandom(){
        $letters = range('a', 'z');
        $random_array = [$letters[rand(0,25)], $letters[rand(0,25)], $letters[rand(0,25)], $letters[rand(0,25)], $letters[rand(0,25)]];
        $random = implode("", $random_array);
        return $random;
    }
}
