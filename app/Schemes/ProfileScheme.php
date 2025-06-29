<?php

namespace App\Schemes;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;

class ProfileScheme
{
    use FieldsMapping;

    public function getScheme(): array
    {
        return [
            [
                SchemeMapping::SCHEME0 => self::FIELD26,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'unique',
                SchemeMapping::SCHEME5 => 'required|email',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD27,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'required|min:6',
            ]
        ];
    }
}
