<?php

namespace App\Utils;

use App\Mapping\FieldsMapping;
use App\Models\ProfileModel;

class UserProfile
{
    use FieldsMapping;

    public $mailUser;
    public function getMailUser($userEmail)
    {
        $user = ProfileModel::where(self::EMAIL, $validated[self::EMAIL])->first();

    }
}
