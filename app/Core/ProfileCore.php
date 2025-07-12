<?php

namespace App\Core;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Models\ProfileModel;
use App\Services\ProfileService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileCore
{
    use FieldsMapping;

    public $user;
    public $refreshToken;
    public $accessToken;

    public function new_refreshToken()
    {
        if (!$this->user) {
            $this->refreshToken = null;
            throw new Exception('User not exists');
        }

        $this->refreshToken = JWTAuth::customClaims([
            'type' => 'refresh',
            'exp'  => now()->addMonths(12)->timestamp
        ])->fromUser($this->user);
    }

    public function new_accessToken()
    {
        if (!$this->refreshToken) {
            $this->accessToken = null;
            throw new Exception('Empty refresh token');
        }

        $this->accessToken = JWTAuth::customClaims([
            'type' => 'access',
            'exp'  => now()->addHours(24)->timestamp
        ])->fromUser(
            JWTAuth::setToken($this->refreshToken)->authenticate()
        );
    }






//    public function authByToken()
//    {
//        $user = JWTAuth::parseToken()->authenticate();
//
//        if (!$user) {
//            $this->user = null;
//            throw new Exception('User not found');
//        }
//
//        $this->user = $user;
//    }
//
//    public function authByCredentials()
//    {
//        $profileService = app(ProfileService::class);
//
//        $credentials = request()->validate($profileService->profileValidate);
//
//        $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();
//
//        if (!$user) {
//            $this->user = null;
//            throw new Exception('Email not found');
//        }
//
//        if (!Hash::check($credentials[self::FIELD27], $user->{self::FIELD27})) {
//            $this->user = null;
//            throw new Exception('Invalid password');
//        }
//
//        $this->user = $user;
//    }
//
//    public function getData($field)
//    {
//        return $this->user->{$field};
//    }
//
//    public function setFieldValue($table, $field, $value)
//    {
//        $serviceClassName = 'App\\Services\\'.ucfirst($table).'Service';
//        $service          = app($serviceClassName);
//        $fields           = $table.'Fields';
//
//        if ($table == TablesMapping::TABLE0) {
//            $this->user->{$field} = $value;
//            $this->user->save();
//        } elseif (in_array($field, $service->$fields)) {
//            $this->user->{$table}->{$field} = $value;
//            $this->user->{$table}->save();
//        }
//    }
}
