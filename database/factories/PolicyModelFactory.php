<?php

namespace Database\Factories;

use App\Mapping\FieldsMapping;
use Illuminate\Database\Eloquent\Factories\Factory;

class PolicyModelFactory extends Factory
{
    use FieldsMapping;

    public function definition(): array
    {
        return [
            self::FIELD25 => json_encode([
                'title'   => 'Privacy Policy',
                'content' => [
                    'data_collection' => 'We collect only necessary information to provide our services.',
                    'data_usage'      => 'Your data is used solely for the purpose of providing and improving our services.',
                    'data_protection' => 'We implement strong security measures to protect your personal information.',
                    'cookies'         => 'We use cookies to improve your experience on our platform.',
                    'third_party'     => 'We do not share your personal information with third parties without your consent.',
                    'updates'         => 'This privacy policy may be updated periodically.'
                ]
            ])
        ];
    }
}
