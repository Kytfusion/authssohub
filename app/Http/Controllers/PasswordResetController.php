<?php

namespace App\Http\Controllers;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class PasswordResetController extends Controller
{
    use FieldsMapping;

    public function sendCode(
        UserService $userService
    ) {
        $userService->getUserByEmail();

        if (!$userService->user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $resetCode = rand(100000, 999999);

        $userService->setFieldValue(TablesMapping::TABLE0, self::FIELD29, $resetCode);
        $userService->setFieldValue(TablesMapping::TABLE0, self::FIELD28, now()->addMinutes(15));

        try {
            Mail::raw(
                "Your password reset code is: $resetCode",
                function ($message) use ($userService) {
                    $message->to($userService->user->{self::FIELD26})
                        ->subject('Password Reset Code')
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send reset code email.'], 500);
        }

        return response()->json(['message' => 'Password reset code sent to email.'], 200);
    }

    public function verifyCode(
        Request $request,
        UserService $userService,
        ProfileService $profileService
    ) {
        unset($profileService->profileValidate[self::FIELD27]);

        $validate = $request->validate($profileService->profileValidate);

        $userService->getUserByEmail();

        if (!$userService->user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $resetCode = $userService->getData(self::FIELD29);

        if ($validate[self::FIELD29] == $resetCode) {
            return response()->json(['message' => 'Password reset code is correct.'], 200);
        } else {
            return response()->json(['message' => 'Password reset code is incorrect.'], 400);
        }
    }

    public function resetPassword(
        Request $request,
        UserService $userService,
        ProfileService $profileService
    ) {
        $validate = $request->validate($profileService->profileValidate);

        $userService->getUserByEmail();

        if (!$userService->user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $passwordResetCode = $userService->getData(self::FIELD29);

        if ($validate[self::FIELD29] == $passwordResetCode) {
            $userService->setFieldValue(TablesMapping::TABLE0, self::FIELD27, Hash::make($validate[self::FIELD27]));
            $userService->setFieldValue(TablesMapping::TABLE0, self::FIELD29, null);
            $userService->setFieldValue(TablesMapping::TABLE0, self::FIELD28, null);

            $token = JWTAuth::fromUser($userService->user);

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Password reset code is incorrect.'], 400);
        }
    }
}

