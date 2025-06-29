<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{
    public function register()
    {
        return response()->json(['message' => 'Register']);
    }
}
