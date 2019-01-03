<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\PrivateUserResource;

class RegisterController extends Controller
{

    /**
     * validate the users credentials
     * store the validated user in db
     *
     * Return a User resource json object
     *
     * @param Request $request
     * @return PrivateUserResource
     */
    public function register(Request $request)
    {
        return new PrivateUserResource(
            User::create(
                $request->validate([
                    'password' => 'required|string|min:6',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'name' => 'required|string|max:255',
                    'locale'=> 'nullable|string',
                    'currency' => 'nullable|string|min:3|max:3'
                ])
            )
        );
    }
}
