<?php

namespace App\Services;

use App\Mapping\FieldsMapping;
use App\Mapping\TablesMapping;
use App\Models\ProfileModel;
use Exception;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    use FieldsMapping;

    public $user;

    public function getUserByEmail()
    {
        $profileService = app(ProfileService::class);

        unset($profileService->profileValidate[self::FIELD27]);

        $credentials = request()->validate($profileService->profileValidate);

        $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

        if ($user) {
            $this->user = $user;
        } else {
            $this->user = null;
        }
    }

    public function authByToken()
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            $this->user = null;
            throw new Exception('User not found');
        }

        $this->user = $user;
    }

    public function authByCredentials()
    {
        $profileService = app(ProfileService::class);

        $credentials = request()->validate($profileService->profileValidate);

        $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

        if (!$user) {
            $this->user = null;
            throw new Exception('Email not found');
        }

        if (!Hash::check($credentials[self::FIELD27], $user->{self::FIELD27})) {
            $this->user = null;
            throw new Exception('Invalid password');
        }

        $this->user = $user;
    }

    public function createProfile()
    {
        $profileService = app(ProfileService::class);

        $credentials = request()->validate($profileService->profileValidate);

        $user = ProfileModel::where(self::FIELD26, $credentials[self::FIELD26])->first();

        if ($user) {
            $this->user = null;
            throw new Exception('Email exists');
        }

        $profileModel = app(ProfileModel::class);

        $profileModel->{self::FIELD26} = $credentials[self::FIELD26];
        $profileModel->{self::FIELD27} = Hash::make($credentials[self::FIELD27]);

        $profileModel->save();

        $profileModel->bio()->create([]);
        $profileModel->options()->create([]);

        $this->user = $profileModel;
    }

    public function getData($field)
    {
        return $this->user->{$field};
    }

    public function setFieldValue($table, $field, $value)
    {
        $serviceClassName = 'App\\Services\\'.ucfirst($table).'Service';
        $service          = app($serviceClassName);
        $fields           = $table.'Fields';

        if ($table == TablesMapping::TABLE0) {
            $this->user->{$field} = $value;
            $this->user->save();
        } elseif (in_array($field, $service->$fields)) {
            $this->user->{$table}->{$field} = $value;
            $this->user->{$table}->save();
        }
    }
}
