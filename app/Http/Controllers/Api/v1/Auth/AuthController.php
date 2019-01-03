<?php

namespace App\Http\Controllers\Api\v1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PrivateUserResource;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('login');
    }

    /**
     * If the provided email and password are correct
     * return a user resource with an access token
     * atatched as metadata
     *
     * If the provided information is not correct
     * return a valiadation error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (! $token = auth()->attempt($request->validate(['email' => 'required', 'password' => 'required']))) {
            return response()->json([
                'errors' => [
                    'email' => ['We could not verify that email or password, try again']
                ]
            ], 422);
        }

        return (new PrivateUserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
