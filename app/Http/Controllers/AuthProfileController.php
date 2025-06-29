<?php

namespace App\Http\Controllers;

use App\Mapping\TablesMapping;
use App\Models\ProfileModel;
use App\Services\BiographyService;
use App\Services\UserService;
use Exception;
use Google_Client;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mapping\FieldsMapping;

class AuthProfileController extends Controller
{
    use FieldsMapping;

    public function mailVerify(
        UserService $userService
    ) {
        try {
            $userService->getUserByEmail();

            if ($userService->user) {
                return response()->json(['exists' => true], 200);
            } else {
                return response()->json(['exists' => false], 200);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function loginUser(
        UserService $userService
    ) {
        try {
            $userService->authByCredentials();

            $token = JWTAuth::fromUser($userService->user);

            return response()->json(['token' => $token]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createProfile(
        UserService $userService,
        BiographyService $biographyService
    ) {
        try {
            $userService->createProfile();

            $validate = request()->validate($biographyService->biographyValidate);
            foreach ($validate as $field => $value) {
                $userService->setFieldValue(TablesMapping::TABLE1, $field, $value);
            }

            $token = JWTAuth::fromUser($userService->user);

            return response()->json(['token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function googleAuth()
    {
        $accessToken = request()->input(self::FIELD39);
        $environment = request()->get(self::FIELD40, 'dev');

        if (!$accessToken) {
            return response()->json(['error' => 'Access token not provided'], 400);
        }

        $GOOGLE_WEB_CLIENT_ID = env('GOOGLE_WEB_CLIENT_ID_PROD');
        if ($environment === 'dev') {
            $GOOGLE_WEB_CLIENT_ID = env('GOOGLE_WEB_CLIENT_ID_DEV');
        }

        $client = new Google_Client();
        $client->setClientId($GOOGLE_WEB_CLIENT_ID);

        try {
            $googlePayload = $client->verifyIdToken($accessToken);

            if ($googlePayload) {
                $email = $googlePayload[self::FIELD26] ?? null;

                if (!$email) {
                    return response()->json(['error' => 'Email not found'], 400);
                }

                $user = ProfileModel::where(self::FIELD26, $email)->first();

                if (!$user) {
                    return response()->json(['exists' => false]);
                }

                $token = JWTAuth::fromUser($user);

                return response()->json(['token' => $token]);
            } else {
                return response()->json(['error' => 'Invalid access token'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error validating access token', 'details' => $e->getMessage()], 500);
        }
    }
}
