<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="HR Management App API Documentation",
 *      version="1.0.0",
 *      @OA\Contact(
 *          email="alabaganne9@gmail.com"     
 *      )
 * ),
 * 
 * @OA\Server(
 *      url="http://localhost:8000"
 * ),
 * 
 * @OA\Tag(
 *      name="Auth",
 *      description="Authentication routes",
 * ),
 * 
 * @OA\Tag(
 *      name="Collaborators",
 *      description="Everything about collaborators",
 * ),
 * 
 * @OA\Tag(
 *      name="Skills",
 *      description="Manage user skills routes",
 * ),
 * 
 * @OA\Response(
 *     response="success",
 *     description="Successful operation",
 *     @OA\JsonContent(
 *         type="array",
 *         @OA\Items()
 *     )
 * ),
 * @OA\Response(
 *     response="unauthorized",
 *     description="Forbidden",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="This action is unauthorized.")
 *     )
 * ),
 * 
 * @oA\Response(
 *      response="unauthenticated",
 *      description="Authentication is required",
 *      @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Unauthenticated.")
 *     )
 * )
 * 
 * @OA\Response(
 *     response="invalid-data",
 *     description="Invalid data",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="The given data was invalid."),
 *         @OA\Property(
 *             property="error",
 *             type="object",
 *             @OA\Property(property="email", type="string", example="The email must be a valid email address.")
 *         )
 *     )
 * )
 * 
 * @OA\RequestBody(
 *      request="collaboratorRequestBody",
 *      required=true,
 *      description="Collaborator request body",
 *      @OA\JsonContent(ref="#/components/schemas/user")
 * )
 * 
 * @OA\RequestBody(
 *      request="searchRequestBody",
 *      required=true,
 *      description="Search",
 *      @OA\JsonContent(
 *          @OA\Property(property="search_text", type="string"),
 *          @OA\Property(property="items_per_page", type="integer", example=10)
 *      )
 * )
 * 
 * @OA\Parameter(
 *      parameter="user_id",
 *      name="user_id",
 *      description="The ID of the user",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          format="int64"
 *      )
 * )
 * 
*/
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $regex = "/^[a-zA-Z0-9 ._\-]+$/i";
}
