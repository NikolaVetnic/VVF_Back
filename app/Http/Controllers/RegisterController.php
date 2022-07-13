<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Register the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register()
    {
        $registerData = request(['firstName', 'email', 'password']);

        return "Test";
    }
}
