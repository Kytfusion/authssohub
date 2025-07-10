<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;

class LoginController extends Controller
{
    public function login(
        ProfileCore $profileCore,
    ) {
        try {
            $profileCore->login_user();

            return response()->json([
                'access_token' => $profileCore->accessToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
