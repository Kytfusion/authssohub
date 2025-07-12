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
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD41,
                SchemeMapping::SCHEME1 => 'text',
                SchemeMapping::SCHEME2 => 'empty',
                SchemeMapping::SCHEME3 => 'change',
                SchemeMapping::SCHEME4 => 'nullable',
                SchemeMapping::SCHEME5 => 'empty',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD42,
                SchemeMapping::SCHEME1 => 'integer',
                SchemeMapping::SCHEME2 => null,
                SchemeMapping::SCHEME3 => json_encode([]),
                SchemeMapping::SCHEME4 => 'nullable',
                SchemeMapping::SCHEME5 => 'nullable|numeric|digits:6',
            ],
            [
                SchemeMapping::SCHEME0 => self::FIELD43,
                SchemeMapping::SCHEME1 => 'timestamp',
                SchemeMapping::SCHEME2 => json_encode([]),
                SchemeMapping::SCHEME3 => json_encode([]),
                SchemeMapping::SCHEME4 => 'nullable',
                SchemeMapping::SCHEME5 => 'nullable',
            ]
        ];
    }
}
