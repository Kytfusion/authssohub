<?php

namespace App\Services;

use App\Schemes\BiographyScheme;
use App\Mapping\SchemeMapping;

class BiographyService extends SchemeMapping
{
    public array $biographyScheme    = [];
    public array $biographyFields    = [];
    public array $biographyMigration = [];
    public array $biographyValidate  = [];

    public function __construct()
    {
        $this->setBiographyScheme();
        $this->setBiographyFields();
        $this->setBiographyMigration();
        $this->setBiographyValidate();
    }

    private function setBiographyScheme(): void
    {
        $biographySchemeInstance = new BiographyScheme();
        $this->biographyScheme   = $biographySchemeInstance->getScheme();
    }

    private function setBiographyFields(): void
    {
        foreach ($this->biographyScheme as $item) {
            $this->biographyFields[] = $item[self::SCHEME0];
        }
    }

    private function setBiographyMigration(): void
    {
        foreach ($this->biographyScheme as $item) {
            $this->biographyMigration[] = [
                SchemeMapping::SCHEME1 => $item[SchemeMapping::SCHEME1],
                SchemeMapping::SCHEME0 => $item[SchemeMapping::SCHEME0],
                SchemeMapping::SCHEME4 => $item[SchemeMapping::SCHEME4],
                SchemeMapping::SCHEME3 => $item[SchemeMapping::SCHEME3],
            ];
        }
    }

    private function setBiographyValidate(): void
    {
        foreach ($this->biographyScheme as $item) {
            $this->biographyValidate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->biographyValidate = array_merge(...$this->biographyValidate);
    }
}
