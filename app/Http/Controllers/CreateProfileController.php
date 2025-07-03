<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;

class CreateProfileController extends Controller
{
    public function register(
        ProfileCore $profileCore,
    ) {
        try {
            $profileCore->createProfile();

            $profileCore->set_refreshToken();
            $profileCore->set_accessToken();

            return response()->json([
                'access_token' => $profileCore->accessToken,
                'refresh_token' => $profileCore->refreshToken,
                'user' => $profileCore->user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
