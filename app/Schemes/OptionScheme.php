<?php

namespace App\Schemes;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;

class OptionScheme
{
    use FieldsMapping;

    public function getScheme()
    {
        return [
            [
                SchemeMapping::SCHEME0 => self::FIELD30,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD31,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD32,
                SchemeMapping::SCHEME1 => 'integer',
                SchemeMapping::SCHEME2 => 0,
                SchemeMapping::SCHEME3 => 0,
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD33,
                SchemeMapping::SCHEME1 => 'json',
                SchemeMapping::SCHEME2 => json_encode([]),
                SchemeMapping::SCHEME3 => json_encode([]),
                SchemeMapping::SCHEME4 => 'nullable',
                SchemeMapping::SCHEME5 => 'nullable',
            ], [
                SchemeMapping::SCHEME0 => self::FIELD37,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ]
        ];
    }
}
