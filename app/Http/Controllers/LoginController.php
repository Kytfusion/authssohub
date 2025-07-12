<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;
use App\Models\ProfileModel;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Hash;
use Exception;

class LoginController extends Controller
{
    public function login(
        ProfileCore $profileCore,
        ProfileService $profileService,
    ) {
        try {
            $credentials = request()->validate($profileService->validate);

            $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

            if (!$user) {
                $profileCore->user = null;
                throw new Exception('Failed authenticate');
            }

            if (!Hash::check($credentials[self::FIELD27], $user->{self::FIELD27})) {
                $profileCore->user = null;
                throw new Exception('Failed authenticate');
            }

            $profileCore->user = $user;

            $profileCore->refreshToken = $user->{self::FIELD41};

            $profileCore->new_accessToken();

            return response()->json([
                'access_token' => $profileCore->accessToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
