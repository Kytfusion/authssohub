<?php

namespace App\Services;

use App\Mapping\SchemeMapping;
use App\Schemes\ProfileScheme;
use App\Models\ProfileModel;

class ProfileService extends SchemeMapping
{
    public array $profileScheme    = [];
    public array $profileFields    = [];
    public array $profileMigration = [];
    public array $profileValidate = [];

    public function __construct()
    {
        $this->setProfileScheme();
        $this->setProfileFields();
        $this->setProfileMigration();
        $this->setProfileValidate();
    }

    private function setProfileScheme(): void
    {
        $profileSchemeInstance = new ProfileScheme();
        $this->profileScheme   = $profileSchemeInstance->getScheme();
    }

    private function setProfileFields(): void
    {
        foreach ($this->profileScheme as $item) {
            $this->profileFields[] = $item[self::SCHEME0];
        }
    }

    private function setProfileMigration(): void
    {
        foreach ($this->profileScheme as $item) {
            $this->profileMigration[] = [
                SchemeMapping::SCHEME1 => $item[SchemeMapping::SCHEME1],
                SchemeMapping::SCHEME0 => $item[SchemeMapping::SCHEME0],
                SchemeMapping::SCHEME4 => $item[SchemeMapping::SCHEME4],
                SchemeMapping::SCHEME3 => $item[SchemeMapping::SCHEME3],
                SchemeMapping::SCHEME5 => $item[SchemeMapping::SCHEME5],
            ];
        }
    }

    private function setProfileValidate(): void
    {
        foreach ($this->profileScheme as $item) {
            $this->profileValidate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->profileValidate = array_merge(...$this->profileValidate);
    }

    public function createOptionsForProfile(ProfileModel $profile): void
    {
        $profile->options()->create([]);
    }
}
