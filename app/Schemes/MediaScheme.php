<?php

namespace App\Schemes;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;

class MediaScheme
{
    use FieldsMapping;

    public function getScheme()
    {
        return [
            [
                SchemeMapping::SCHEME0 => self::FIELD34,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ], [
                SchemeMapping::SCHEME0 => self::FIELD35,
                SchemeMapping::SCHEME1 => 'string',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'empty',
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ], [
                SchemeMapping::SCHEME0 => self::FIELD36,
                SchemeMapping::SCHEME1 => 'integer',
                SchemeMapping::SCHEME2 => 0,
                SchemeMapping::SCHEME3 => 0,
                SchemeMapping::SCHEME4 => 'default',
                SchemeMapping::SCHEME5 => 'nullable',
            ],
        ];
    }
}
