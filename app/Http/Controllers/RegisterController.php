<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;
use App\Models\ProfileModel;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterController extends Controller
{
    public function register(
        ProfileCore $profileCore,
        ProfileService $profileService,
        ProfileModel $profileModel
    ) {
        try {
            $credentials = request()->validate($profileService->validate);

            $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

            if ($user) {
                $profileCore->user = null;
                throw new Exception('Email exists');
            }

            $profileModel->{self::FIELD26} = $credentials[self::FIELD26];
            $profileModel->{self::FIELD27} = Hash::make($credentials[self::FIELD27]);
            $profileModel->save();

            $profileCore->user = $profileModel;

            $profileCore->new_refreshToken();
            $profileCore->new_accessToken();

            $profileModel->{self::FIELD41} = $profileCore->refreshToken;
            $profileModel->save();

            return response()->json([
                'access_token' => $profileCore->accessToken,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
