<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
    */

    /**
    * @OA\Post(
    *       path="/api/auth/login",
    *       summary="Login",
    *       tags={"Auth"},
    *       description="Authenticate a user with email and password",
    *       operationId="login",
    *       @OA\requestBody(
    *           required=true,
    *           description="User credentials",
    *           @OA\JsonContent(
    *               @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
    *               @OA\Property(property="password", type="string", format="password", example="Password1234")        
    *           )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           description="Logged in",
    *           @OA\JsonContent(
    *               @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwMTA3MTg1OSwiZXhwIjoxNjAxMTU4MjU5LCJuYmYiOjE2MDEwNzE4NTksImp0aSI6Ik9YeTdieXI3UGpkNnBaZ1kiLCJzdWIiOjMsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.ewMSg-07JHs6YxKME0UdNMYI0CvhaE9XeWEWOSRgHRE"),
    *               @OA\Property(property="token_type", type="string", example="bearer"),
    *               @OA\Property(property="expires_in", type="integer", example=86400)
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Invalid credentials",
    *           @OA\JsonContent(
    *               @OA\Property(property="message", type="string", example="The provided credentials are incorrect.")
    *           )
    *       ),
    *       @OA\Response(response=422, ref="#/components/responses/invalid-data")
     * )
    */
    public function login()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *      path="api/auth/me",
     *      tags={"Auth"},
     *      summary="User informations",
     *      description="Get current user informations",
     *      operationId="me",
     *      @OA\Response(
     *          response=200,
     *          description="User information",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/user"
     *          )
     *      ),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated")
     * )
    */
    public function me()
    {
        return new UserResource(auth()->user());
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      tags={"Auth"},
     *      summary="Logout",
     *      description="Logout current user",
     *      operationId="logout",
     *      @OA\Response(
     *          response=200,
     *          description="Logout response",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", example="Successfully logged out")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/unauthenticated"
     *      )
     * )
    */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}