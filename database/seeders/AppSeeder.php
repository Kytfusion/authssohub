<?php

namespace Database\Seeders;

use App\Mapping\FieldsMapping;
use App\Models\OptionModel;
use App\Models\PolicyModel;
use App\Schemes\PolicyScheme;
use App\Utils\CoordsDistance;
use Database\Factories\OptionModelFactory;
use Database\Factories\PolicyModelFactory;
use Illuminate\Database\Seeder;
use App\Models\ProfileModel;
use App\Models\BiographyModel;
use Illuminate\Support\Str;
use DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class AppSeeder extends Seeder
{
    use FieldsMapping;
    use CoordsDistance;

    public function run()
    {
        $faker            = Faker::create();
        $refLat           = -25.293018;
        $refLon           = -109.626514;
        $usersPerDistance = 5;

        $profileSeed   = [];
        $biographySeed = [];
        $policySeed    = [];
        $mediaSeed     = [];
        $optionSeed    = [];

        for ($i = 0; $i < 9; $i++) {
            $bearing   = $faker->numberBetween(0, 360);
            $coords    = $this->calculateCoordinatesAtDistance($refLat, $refLon, $faker->numberBetween(1, 150),
                $bearing);
            $gender    = $faker->randomElement(['male', 'female']);
            $firstName = $gender === 'male' ? $faker->firstName('male') : ($gender === 'female' ? $faker->firstName('female') : $faker->firstName());
            $lastName  = $faker->lastName;
            $email     = strtolower($firstName.'.'.$lastName.'@'.$faker->freeEmailDomain);
            $age       = $faker->numberBetween(18, 80);
            $birthDate = $faker->dateTimeBetween('-'.$age.' years', '-'.($age - 1).' years')->format('Y-m-d');
            $password  = Hash::make('123qwe!@#QWE');

            $profileSeed[self::FIELD26]   = $email;
            $profileSeed[self::FIELD27]   = $password;
            $biographySeed[self::FIELD0]  = $firstName.' '.$lastName;
            $biographySeed[self::FIELD1]  = $gender;
            $biographySeed[self::FIELD2]  = $birthDate;
            $biographySeed[self::FIELD10] = $age;
            $biographySeed[self::FIELD21] = [
                'latitude'  => $coords['latitude'],
                'longitude' => $coords['longitude']
            ];
            $biographySeed[self::FIELD3]  = $faker->paragraph(2);
            $biographySeed[self::FIELD22] = [
                'min' => $age - $faker->numberBetween(5, 10),
                'max' => $age + $faker->numberBetween(5, 10),
            ];
            $biographySeed[self::FIELD11] = $faker->numberBetween(1, 100);
            $biographySeed[self::FIELD12] = $faker->numberBetween(1, 6);

            $profile = ProfileModel::create($profileSeed);
            $biographySeed[self::FIELD38] = $profile->id;
            BiographyModel::create($biographySeed);

            $factory = new OptionModelFactory();
            $options = $factory->definition();
            foreach ($options as $option) {
                $option[self::FIELD38] = $profile->id;
                OptionModel::create($option);
            }
        }

        PolicyModel::factory()->create();
    }
}
