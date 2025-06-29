<?php

namespace App\Schemes;

use App\Mapping\FieldsMapping;
use App\Mapping\SchemeMapping;

class BiographyScheme
{
    use FieldsMapping;

    public function getScheme()
    {
        return [
            [
                SchemeMapping::SCHEME0   => self::FIELD0,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD1,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD2,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD3,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD4,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD5,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD6,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD7,
                SchemeMapping::SCHEME1   => 'string',
                SchemeMapping::SCHEME2   => 'nullable',
                SchemeMapping::SCHEME3   => 'nullable',
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'string|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD8,
                SchemeMapping::SCHEME1   => 'integer',
                SchemeMapping::SCHEME2   => 0,
                SchemeMapping::SCHEME3   => 0,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'integer|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD9,
                SchemeMapping::SCHEME1   => 'integer',
                SchemeMapping::SCHEME2   => 0,
                SchemeMapping::SCHEME3   => 0,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'integer|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD10,
                SchemeMapping::SCHEME1   => 'integer',
                SchemeMapping::SCHEME2   => 0,
                SchemeMapping::SCHEME3   => 0,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'integer|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD11,
                SchemeMapping::SCHEME1   => 'integer',
                SchemeMapping::SCHEME2   => 0,
                SchemeMapping::SCHEME3   => 0,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'integer|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD12,
                SchemeMapping::SCHEME1   => 'integer',
                SchemeMapping::SCHEME2   => 0,
                SchemeMapping::SCHEME3   => 0,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'integer|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD13,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD14,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD15,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD16,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD17,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD18,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD19,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD20,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD21,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD22,
                SchemeMapping::SCHEME1   => 'json',
                SchemeMapping::SCHEME2   => json_encode([]),
                SchemeMapping::SCHEME3   => json_encode([]),
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'array|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD23,
                SchemeMapping::SCHEME1   => 'boolean',
                SchemeMapping::SCHEME2   => false,
                SchemeMapping::SCHEME3   => false,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'boolean|nullable',
            ], [
                SchemeMapping::SCHEME0   => self::FIELD24,
                SchemeMapping::SCHEME1   => 'boolean',
                SchemeMapping::SCHEME2   => false,
                SchemeMapping::SCHEME3   => false,
                SchemeMapping::SCHEME4   => 'default',
                SchemeMapping::SCHEME5   => 'boolean|nullable',
            ]
        ];
    }
}
