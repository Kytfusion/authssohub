<?php

namespace App\Schemes;

use App\Mapping\SchemeMapping;
use \App\Mapping\FieldsMapping;

class PolicyScheme
{
    use FieldsMapping;

    public function getScheme()
    {
        return [
            [
                SchemeMapping::SCHEME0 => self::FIELD25,
                SchemeMapping::SCHEME1 => 'json',
                SchemeMapping::SCHEME2 => json_encode([]),
                SchemeMapping::SCHEME3 => json_encode([]),
                SchemeMapping::SCHEME4 => 'nullable',
                SchemeMapping::SCHEME5 => 'nullable',
            ]
        ];
    }
}
