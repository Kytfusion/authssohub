<?php

namespace App\Http\Controllers;

use App\Services\BiographyService;
use App\Services\UserService;

class UserProfileController extends Controller
{

    public function userProfile(
        UserService $userService
    ) {
        $userService->authByToken();

        return $userService->user->biography;
    }



}
