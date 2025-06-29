<?php

namespace App\Services;

use App\Mapping\SchemeMapping;
use App\Schemes\OptionScheme;

class OptionService extends SchemeMapping
{
    public array $optionScheme     = [];
    public array $optionsFields    = [];
    public array $optionsMigration = [];
    public array $optionValidate = [];

    public function __construct()
    {
        $this->setOptionsScheme();
        $this->setOptionsFields();
        $this->setOptionsMigration();
        $this->setOptionValidate();
    }

    private function setOptionsScheme(): void
    {
        $optionsInstance    = new OptionScheme();
        $this->optionScheme = $optionsInstance->getScheme();
    }

    private function setOptionsFields(): void
    {
        foreach ($this->optionScheme as $item) {
            $this->optionsFields[] = $item[self::SCHEME0];
        }
    }

    private function setOptionsMigration(): void
    {
        foreach ($this->optionScheme as $item) {
            $this->optionsMigration[] = [
                SchemeMapping::SCHEME1 => $item[SchemeMapping::SCHEME1],
                SchemeMapping::SCHEME0 => $item[SchemeMapping::SCHEME0],
                SchemeMapping::SCHEME4 => $item[SchemeMapping::SCHEME4],
                SchemeMapping::SCHEME3 => $item[SchemeMapping::SCHEME3],
            ];
        }
    }

    private function setOptionValidate(): void
    {
        foreach ($this->optionScheme as $item) {
            $this->optionValidate[] = [
                $item[SchemeMapping::SCHEME0] => $item[SchemeMapping::SCHEME5],
            ];
        }

        $this->optionValidate = array_merge(...$this->optionValidate);
    }
}
