<?php

namespace App\Services;

use App\Mapping\SchemeMapping;
use App\Schemes\ProfileScheme;

class ProfileService extends SchemeMapping
{
    public array $scheme    = [];
    public array $fields    = [];
    public array $migration = [];
    public array $validate  = [];

    public function __construct()
    {
        $this->setScheme();
        $this->setFields();
        $this->setMigration();
        $this->setValidate();
    }

    private function setScheme(): void
    {
        $this->scheme = app(ProfileScheme::class)->getScheme();
    }

    private function setFields(): void
    {
        foreach ($this->scheme as $item) {
            $this->fields[] = $item[self::SCHEME0];
        }
    }

    private function setMigration(): void
    {
        foreach ($this->scheme as $item) {
            $this->migration[] = $item;
        }
    }

    private function setValidate(): void
    {
        foreach ($this->scheme as $item) {
            $this->validate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->validate = array_merge(...$this->validate);
    }

}
