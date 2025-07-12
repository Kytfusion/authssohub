<?php

namespace App\Http\Controllers;

use App\Core\ProfileCore;
use App\Mapping\TablesMapping;
use App\Models\ProfileModel;
use App\Services\ProfileService;
use Exception;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function code(
        ProfileCore $profileCore,
        ProfileService $profileService
    ) {
        try {
            unset($profileService->validate[self::FIELD27]);

            $credentials = request()->validate($profileService->validate);

            $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

            if (!$user) {
                $profileCore->user = null;
                throw new Exception('Email not exists');
            }

            $profileCore->user = $user;

            $resetCode = rand(100000, 999999);

            $user->{self::FIELD42} = $resetCode;
            $user->{self::FIELD43} = now()->addMinutes(15);
            $user->save();

            try {
                Mail::raw(
                    "Your password reset code is: $resetCode",
                    function ($message) use ($profileCore) {
                        $message->to($profileCore->user->{self::FIELD26})
                            ->subject('Password Reset Code')
                            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });
            } catch (\Exception $e) {
                throw new Exception('Failed to send reset code email.');
            }

            return response()->json(['message' => 'Password reset code sent to email.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
