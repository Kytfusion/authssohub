<?php

namespace App\Services;

use App\Mapping\SchemeMapping;
use App\Schemes\MediaScheme;

class MediaService extends SchemeMapping
{
    public array $mediaScheme    = [];
    public array $mediaFields    = [];
    public array $mediaMigration = [];
    public array $mediaValidate = [];

    public function __construct()
    {
        $this->setMediaScheme();
        $this->setMediaFields();
        $this->setMediaMigration();
        $this->setMediaValidate();
    }

    private function setMediaScheme(): void
    {
        $mediaSchemeInstance = new MediaScheme();
        $this->mediaScheme   = $mediaSchemeInstance->getScheme();
    }

    private function setMediaFields(): void
    {
        foreach ($this->mediaScheme as $item) {
            $this->mediaFields[] = $item[self::SCHEME0];
        }
    }

    private function setMediaMigration(): void
    {
        foreach ($this->mediaScheme as $item) {
            $this->mediaMigration[] = [
                SchemeMapping::SCHEME1 => $item[SchemeMapping::SCHEME1],
                SchemeMapping::SCHEME0 => $item[SchemeMapping::SCHEME0],
                SchemeMapping::SCHEME4 => $item[SchemeMapping::SCHEME4],
                SchemeMapping::SCHEME3 => $item[SchemeMapping::SCHEME3],
            ];
        }
    }

    private function setMediaValidate(): void
    {
        foreach ($this->mediaScheme as $item) {
            $this->mediaValidate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->mediaValidate = array_merge(...$this->mediaValidate);
    }
}
