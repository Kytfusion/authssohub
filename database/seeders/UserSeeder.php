<?php

namespace Database\Seeders;

use App\Models\ProfileBio;
use App\Models\ProfileCredential;
use App\Models\ProfileImage;
use App\Models\ProfileRestoring;
use App\Models\ProfileMatch;
use App\Mapping\FieldsMapping;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    use FieldsMapping;

    private function calculateCoordinatesAtDistance($lat, $lon, $distance, $bearing) {
        $earthRadius = 6371; // Earth's radius in kilometers

        // Convert to radians
        $lat = deg2rad($lat);
        $lon = deg2rad($lon);
        $bearing = deg2rad($bearing);

        // Calculate new coordinates
        $newLat = asin(sin($lat) * cos($distance/$earthRadius) +
                      cos($lat) * sin($distance/$earthRadius) * cos($bearing));

        $newLon = $lon + atan2(sin($bearing) * sin($distance/$earthRadius) * cos($lat),
                              cos($distance/$earthRadius) - sin($lat) * sin($newLat));

        // Convert back to degrees
        return [
            'latitude' => rad2deg($newLat),
            'longitude' => rad2deg($newLon)
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $languages          = ['English', 'Spanish', 'French', 'German', 'Mandarin', 'Italian'];
        $musicGenres        = ['Rock', 'Pop', 'Jazz', 'Classical', 'Hip-Hop', 'Electronic'];
        $movieGenres        = ['Action', 'Comedy', 'Drama', 'Sci-Fi', 'Romance', 'Thriller'];
        $bookGenres         = ['Fiction', 'Non-Fiction', 'Mystery', 'Fantasy', 'Biography', 'Science'];
        $travelDestinations = ['Paris', 'Tokyo', 'New York', 'Beach', 'Mountains', 'Safari'];
        $socialPlatforms    = ['Instagram', 'Twitter', 'Facebook', 'LinkedIn', 'TikTok', 'Snapchat'];
        $religions          = ['', 'Christianity', 'Islam', 'Hinduism', 'Buddhism', 'Judaism', 'None'];
        $preferenceGenders  = ['male', 'female', 'both'];
        $relationshipGoals  = ['dating', 'friendship', 'casual', 'serious relationship', 'networking', 'open to options', 'exploration'];
        $interests          = ['hiking', 'movies', 'reading', 'traveling', 'cooking', 'sports', 'music', 'gaming'];

        $refLat = -25.293018;
        $refLon = -109.626514;

        $distances = [1, 5, 50, 100];
        $usersPerDistance = 5;

        foreach ($distances as $distance) {
            for ($i = 0; $i < $usersPerDistance; $i++) {
                $bearing = $faker->numberBetween(0, 360);

                $coords = $this->calculateCoordinatesAtDistance($refLat, $refLon, $distance, $bearing);

                $gender       = $faker->randomElement(['male', 'female']);
                $firstName    = $gender === 'male' ? $faker->firstName('male') : ($gender === 'female' ? $faker->firstName('female') : $faker->firstName());
                $lastName     = $faker->lastName;
                $email        = strtolower($firstName.'.'.$lastName.'@'.$faker->freeEmailDomain);
                $age          = $faker->numberBetween(18, 80);
                $birthDate    = $faker->dateTimeBetween('-'.$age.' years', '-'.($age - 1).' years')->format('Y-m-d');
                $genderFolder = $gender === 'male' ? 'men' : ($gender === 'female' ? 'women' : 'female');

                $credential = ProfileCredential::create([
                    self::EMAIL    => $email,
                    self::PASSWORD => Hash::make('123qwe!@#QWE'),
                ]);

                ProfileBio::create([
                    self::PROFILE_ID  => $credential->id,
                    self::NAME        => $firstName.' '.$lastName,
                    self::GENDER      => $gender,
                    self::BIRTH       => $birthDate,
                    self::AGE         => $age,
                    self::LOCATION    => json_encode(['latitude' => $coords['latitude'], 'longitude' => $coords['longitude']]),
                    self::CITY        => $faker->city,
                    self::DESCRIPTION => $faker->paragraph(2),
                    self::HEIGHT      => $faker->numberBetween(150, 200),
                    self::WEIGHT      => $faker->numberBetween(50, 100),
                    self::LANGUAGES   => json_encode($faker->randomElements($languages, $faker->numberBetween(1, 3))),
                    self::MUSIC       => json_encode($faker->randomElements($musicGenres, $faker->numberBetween(1, 3))),
                    self::MOVIES      => json_encode($faker->randomElements($movieGenres, $faker->numberBetween(1, 3))),
                    self::BOOKS       => json_encode($faker->randomElements($bookGenres, $faker->numberBetween(1, 3))),
                    self::TRAVEL      => json_encode($faker->randomElements($travelDestinations, $faker->numberBetween(1, 3))),
                    self::SOCIAL      => json_encode($faker->randomElements($socialPlatforms, $faker->numberBetween(1, 3))),
                    self::RELIGION    => $faker->randomElement($religions),
                ]);

                ProfileImage::create([
                    self::PROFILE_ID => $credential->id,
                    self::TITLE      => 'user-photo-'.$i.'.jpg',
                    self::URL        => 'https://twingle-storage.b-cdn.net/user_fake/'.$genderFolder.'/images/user-photo-'.$i.'.jpg',
                ]);

                ProfileMatch::create([
                    self::PROFILE_ID        => $credential->id,
                    self::PREFERENCE_GENDER => $faker->randomElement($preferenceGenders),
                    self::PREFERENCE_AGE    => json_encode([
                        'min' => $age - $faker->numberBetween(5, 10),
                        'max' => $age + $faker->numberBetween(5, 10),
                    ]),
                    self::DISTANCE          => $faker->numberBetween(1, 100),
                    self::RELATIONSHIP      => json_encode($faker->randomElements($relationshipGoals, $faker->numberBetween(1, 3))),
                    self::INTERESTS         => json_encode($faker->randomElements($interests, $faker->numberBetween(1, 4))),
                    self::DISABLE_DISTANCE  => $faker->boolean(),
                    self::EMPTY_DESCRIPTION => $faker->boolean(),
                    self::PHOTO_NUMBER      => $faker->numberBetween(1, 6),
                ]);

                ProfileRestoring::create([
                    self::PROFILE_ID          => $credential->id,
                    self::PASSWORD_RESET_CODE => null,
                    self::RESET_CODE_EXPIRY   => null,
                    self::UNIT_OF_MEASUREMENT => $faker->randomElement(['km', 'mi']),
                ]);
            }
        }
    }
}
