<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;
use App\Mapping\TablesMapping;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function register(
        ProfileCore $profileCore,
    ) {
        try {
            $profileCore->createProfile();

            return response()->json([
                $profileCore->user
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
