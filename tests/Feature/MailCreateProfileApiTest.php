<?php

namespace Tests\Feature;

use App\Mapping\FieldsMapping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class MailCreateProfileApiTest extends TestCase
{
    use RefreshDatabase;
    use FieldsMapping;

    protected $validData;

    public function setUp(): void
    {
        parent::setUp();
        $this->validData = [
            self::EMAIL    => 'test@example.com',
            self::PASSWORD => '123qweASD',
            self::NAME     => 'John Doe',
            self::GENDER   => 'male',
            self::BIRTH    => '1990-01-01',
            self::LOCATION => json_encode([
                'latitude' => 47.0105,
                'longitude' => 28.8638
            ]),
            self::HEIGHT   => 170,
            self::WEIGHT   => 75,
            self::DESCRIPTION => 'test',
            self::RELIGION => 'test',
            self::SOCIAL   => json_encode([
                'url' => 'https://example.com',
                'user_name' => 'testuser'
            ]),
            self::LANGUAGES => ['română', 'rusă', 'engleză'],
            self::MUSIC => ['pop', 'rock', 'jazz'],
            self::MOVIES => ['acțiune', 'comedie', 'dramă'],
            self::BOOKS => ['ficțiune', 'non-ficțiune', 'poezie'],
            self::TRAVEL => ['Europa', 'Asia', 'America'],
            self::PREFERENCE_GENDER => 'female',
            self::DISTANCE => 50,
            self::RELATIONSHIP => ['inilniri', 'prieteni'],
            self::INTERESTS => ['calatorii', 'filme'],
            self::PREFERENCE_AGE => json_encode([
                'min' => 18,
                'max' => 25
            ]),
        ];
    }

    private function makeCreateProfileRequest($data)
    {
        return $this->postJson('/api/create-profile', $data);
    }

    public function can_create_profile_with_valid_data()
    {
        $response = $this->makeCreateProfileRequest($this->validData);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_credentials', [
            'email' => $this->validData[self::EMAIL]
        ]);

        $locationData = json_decode($this->validData[self::LOCATION], true);
        $this->assertDatabaseHas('profile_bio', [
            'location' => json_encode($locationData)
        ]);
    }

    public function cannot_create_profile_with_invalid_email()
    {
        $invalidData = $this->validData;
        $invalidData[self::EMAIL] = 'invalid-email';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::EMAIL]);
    }

    public function cannot_create_profile_with_weak_password()
    {
        $invalidData = $this->validData;
        $invalidData[self::PASSWORD] = 'weak';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::PASSWORD]);
    }

    public function cannot_create_profile_with_duplicate_email()
    {
        $this->makeCreateProfileRequest($this->validData);

        $response = $this->makeCreateProfileRequest($this->validData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::EMAIL]);
    }

    public function cannot_create_profile_with_empty_name()
    {
        $invalidData = $this->validData;
        $invalidData[self::NAME] = '';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::NAME]);
    }

    public function cannot_create_profile_with_short_name()
    {
        $invalidData = $this->validData;
        $invalidData[self::NAME] = 'Jo';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::NAME]);
    }

    public function cannot_create_profile_with_invalid_gender()
    {
        $invalidData = $this->validData;
        $invalidData[self::GENDER] = 'invalid-gender';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::GENDER]);
    }

    public function cannot_create_profile_with_missing_gender()
    {
        $invalidData = $this->validData;
        unset($invalidData[self::GENDER]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::GENDER]);
    }

    public function can_create_profile_with_valid_gender_values()
    {
        $validGenders = ['male', 'female', 'other'];
        
        foreach ($validGenders as $gender) {
            $data = $this->validData;
            $data[self::GENDER] = $gender;
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_bio', [
                'gender' => $gender
            ]);
        }
    }

    public function cannot_create_profile_with_missing_birth()
    {
        $invalidData = $this->validData;
        unset($invalidData[self::BIRTH]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::BIRTH]);
    }

    public function cannot_create_profile_with_invalid_birth_format()
    {
        $invalidData = $this->validData;
        $invalidData[self::BIRTH] = 'invalid-date';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::BIRTH]);
    }

    public function cannot_create_profile_with_future_birth_date()
    {
        $invalidData = $this->validData;
        $invalidData[self::BIRTH] = date('Y-m-d', strtotime('+1 year'));

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::BIRTH]);
    }

    public function can_create_profile_with_valid_birth_date()
    {
        $validDates = [
            '1990-01-01',
            '2000-12-31',
            '1985-06-15',
            '1995-03-20'
        ];
        
        foreach ($validDates as $date) {
            $data = $this->validData;
            $data[self::BIRTH] = $date;
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_bio', [
                'birth' => $date
            ]);
        }
    }

    public function correctly_calculates_age_for_specific_birth_date()
    {
        $data = $this->validData;
        $birthDate = '2000-01-01';
        $data[self::BIRTH] = $birthDate;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $expectedAge = date('Y') - 2000;
        if (date('n') < 1 || (date('n') == 1 && date('j') < 1)) {
            $expectedAge--;
        }

        $this->assertDatabaseHas('profile_bio', [
            'birth' => $birthDate,
            'age' => $expectedAge
        ]);
    }

    public function correctly_calculates_age_for_multiple_birth_dates()
    {
        $birthDates = [
            '1990-01-01' => date('Y') - 1990,
            '2000-12-31' => date('Y') - 2000,
            '1985-06-15' => date('Y') - 1985,
            '1995-03-20' => date('Y') - 1995
        ];

        foreach ($birthDates as $birthDate => $expectedAge) {
            $data = $this->validData;
            $data[self::BIRTH] = $birthDate;
            $data[self::EMAIL] = 'test' . uniqid('', true) . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $birthDateTime = new \DateTime($birthDate);
            $today = new \DateTime();
            if ($birthDateTime->format('m-d') > $today->format('m-d')) {
                $expectedAge--;
            }

            $this->assertDatabaseHas('profile_bio', [
                'birth' => $birthDate,
                'age' => $expectedAge
            ]);
        }
    }

    public function cannot_create_profile_with_missing_location()
    {
        $invalidData = $this->validData;
        unset($invalidData[self::LOCATION]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::LOCATION]);
    }

    public function cannot_create_profile_with_invalid_location_json()
    {
        $invalidData = $this->validData;
        $invalidData[self::LOCATION] = 'invalid-json';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Location must contain latitude and longitude'
            ]);
    }

    public function cannot_create_profile_with_missing_location_fields()
    {
        $invalidData = $this->validData;
        $invalidData[self::LOCATION] = json_encode(['latitude' => 47.0105]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Location must contain latitude and longitude'
            ]);
    }

    public function cannot_create_profile_with_invalid_coordinates()
    {
        $invalidData = $this->validData;
        $invalidData[self::LOCATION] = json_encode([
            'latitude' => 'test',
            'longitude' => 'test'
        ]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Invalid location coordinates. Latitude must be between -90 and 90, and longitude between -180 and 180'
            ]);
    }

    public function cannot_create_profile_with_out_of_range_coordinates()
    {
        $invalidData = $this->validData;
        $invalidData[self::LOCATION] = json_encode([
            'latitude' => 91,
            'longitude' => 181
        ]);

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Invalid location coordinates. Latitude must be between -90 and 90, and longitude between -180 and 180'
            ]);
    }

    public function can_create_profile_with_valid_locations()
    {
        $validLocations = [
            ['latitude' => 47.0105, 'longitude' => 28.8638], // Chisinau
            ['latitude' => 47.7617, 'longitude' => 27.9284], // Balti
            ['latitude' => 47.3845, 'longitude' => 28.8244], // Orhei
            ['latitude' => 45.9075, 'longitude' => 28.1944], // Cahul
        ];
        
        foreach ($validLocations as $location) {
            $data = $this->validData;
            $data[self::LOCATION] = json_encode($location);
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_bio', [
                'location' => json_encode($location)
            ]);
        }
    }

    public function can_create_profile_with_location_as_array()
    {
        $data = $this->validData;
        $data[self::LOCATION] = [
            'latitude' => 47.0105,
            'longitude' => 28.8638
        ];
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'location' => json_encode($data[self::LOCATION])
        ]);
    }

    public function can_create_profile_with_height_and_weight()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::HEIGHT] = '175cm';
        $data[self::WEIGHT] = '70kg';
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'height' => '175cm',
            'weight' => '70kg'
        ]);
    }

    public function can_create_profile_without_height_and_weight()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::HEIGHT]);
        unset($data[self::WEIGHT]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'height' => null,
            'weight' => null
        ]);
    }

    public function cannot_create_profile_with_invalid_height_format()
    {
        $invalidData = $this->validData;
        $invalidData[self::HEIGHT] = 'invalid-height';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::HEIGHT]);
    }

    public function cannot_create_profile_with_invalid_weight_format()
    {
        $invalidData = $this->validData;
        $invalidData[self::WEIGHT] = 'invalid-weight';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::WEIGHT]);
    }

    public function can_create_profile_with_description_and_religion()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::DESCRIPTION] = 'This is a test description';
        $data[self::RELIGION] = 'Orthodox';
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'description' => 'This is a test description',
            'religion' => 'Orthodox'
        ]);
    }

    public function can_create_profile_without_description_and_religion()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::DESCRIPTION]);
        unset($data[self::RELIGION]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'description' => null,
            'religion' => null
        ]);
    }

    public function cannot_create_profile_with_too_long_description()
    {
        $invalidData = $this->validData;
        $invalidData[self::DESCRIPTION] = str_repeat('a', 1001);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::DESCRIPTION]);
    }

    public function cannot_create_profile_with_too_long_religion()
    {
        $invalidData = $this->validData;
        $invalidData[self::RELIGION] = str_repeat('a', 256);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::RELIGION]);
    }

    public function can_create_profile_with_social_data()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $socialData = [
            'url' => 'https://example.com',
            'user_name' => 'testuser'
        ];
        $data[self::SOCIAL] = json_encode($socialData);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'social' => json_encode($socialData)
        ]);
    }

    public function can_create_profile_without_social_data()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::SOCIAL]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'social' => null
        ]);
    }

    public function cannot_create_profile_with_invalid_social_data()
    {
        $invalidData = $this->validData;
        $invalidData[self::SOCIAL] = json_encode([
            'url' => 'https://example.com'
            // missing user_name
        ]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Social data must contain url and user_name'
            ]);
    }

    public function cannot_create_profile_with_invalid_social_json()
    {
        $invalidData = $this->validData;
        $invalidData[self::SOCIAL] = 'invalid-json';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500);
    }

    public function can_create_profile_with_languages()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::LANGUAGES] = ['română', 'rusă', 'engleză'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'languages' => json_encode($data[self::LANGUAGES])
        ]);
    }

    public function can_create_profile_without_languages()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::LANGUAGES]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'languages' => null
        ]);
    }

    public function cannot_create_profile_with_non_array_languages()
    {
        $invalidData = $this->validData;
        $invalidData[self::LANGUAGES] = 'not-an-array';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::LANGUAGES]);
    }

    public function can_create_profile_with_music()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::MUSIC] = ['pop', 'rock', 'jazz'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'music' => json_encode($data[self::MUSIC])
        ]);
    }

    public function can_create_profile_without_music()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::MUSIC]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'music' => null
        ]);
    }

    public function cannot_create_profile_with_non_array_music()
    {
        $invalidData = $this->validData;
        $invalidData[self::MUSIC] = 'not-an-array';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::MUSIC]);
    }

    public function can_create_profile_with_movies()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::MOVIES] = ['acțiune', 'comedie', 'dramă'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'movies' => json_encode($data[self::MOVIES])
        ]);
    }

    public function can_create_profile_without_movies()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::MOVIES]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'movies' => null
        ]);
    }

    public function cannot_create_profile_with_non_array_movies()
    {
        $invalidData = $this->validData;
        $invalidData[self::MOVIES] = 'not-an-array';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::MOVIES]);
    }

    public function can_create_profile_with_books()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::BOOKS] = ['ficțiune', 'non-ficțiune', 'poezie'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'books' => json_encode($data[self::BOOKS])
        ]);
    }

    public function can_create_profile_without_books()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::BOOKS]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'books' => null
        ]);
    }

    public function cannot_create_profile_with_non_array_books()
    {
        $invalidData = $this->validData;
        $invalidData[self::BOOKS] = 'not-an-array';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::BOOKS]);
    }

    public function can_create_profile_with_travel()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::TRAVEL] = ['Europa', 'Asia', 'America'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'travel' => json_encode($data[self::TRAVEL])
        ]);
    }

    public function can_create_profile_without_travel()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::TRAVEL]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_bio', [
            'travel' => null
        ]);
    }

    public function cannot_create_profile_with_non_array_travel()
    {
        $invalidData = $this->validData;
        $invalidData[self::TRAVEL] = 'not-an-array';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::TRAVEL]);
    }

    public function cannot_create_profile_with_missing_preference_gender()
    {
        $invalidData = $this->validData;
        unset($invalidData[self::PREFERENCE_GENDER]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::PREFERENCE_GENDER]);
    }

    public function cannot_create_profile_with_invalid_preference_gender()
    {
        $invalidData = $this->validData;
        $invalidData[self::PREFERENCE_GENDER] = 'invalid-gender';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::PREFERENCE_GENDER]);
    }

    public function can_create_profile_with_valid_preference_gender_values()
    {
        $validGenders = ['male', 'female', 'other'];
        
        foreach ($validGenders as $gender) {
            $data = $this->validData;
            $data[self::PREFERENCE_GENDER] = $gender;
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_match', [
                'preference_gender' => $gender,
                'distance' => $this->validData[self::DISTANCE]
            ]);
        }
    }

    public function cannot_create_profile_with_missing_distance()
    {
        $invalidData = $this->validData;
        unset($invalidData[self::DISTANCE]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::DISTANCE]);
    }

    public function cannot_create_profile_with_negative_distance()
    {
        $invalidData = $this->validData;
        $invalidData[self::DISTANCE] = -1;
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::DISTANCE]);
    }

    public function cannot_create_profile_with_too_large_distance()
    {
        $invalidData = $this->validData;
        $invalidData[self::DISTANCE] = 1001;
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::DISTANCE]);
    }

    public function cannot_create_profile_with_non_numeric_distance()
    {
        $invalidData = $this->validData;
        $invalidData[self::DISTANCE] = 'not-a-number';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::DISTANCE]);
    }

    public function can_create_profile_with_valid_distance_values()
    {
        $validDistances = [0, 10, 50, 100, 500, 1000];
        
        foreach ($validDistances as $distance) {
            $data = $this->validData;
            $data[self::DISTANCE] = $distance;
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_match', [
                'distance' => $distance
            ]);
        }
    }

    public function can_create_profile_with_relationship_and_interests()
    {
        $response = $this->makeCreateProfileRequest($this->validData);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => json_encode($this->validData[self::RELATIONSHIP]),
            self::INTERESTS => json_encode($this->validData[self::INTERESTS])
        ]);
    }

    public function can_create_profile_without_relationship_and_interests()
    {
        $data = $this->validData;
        unset($data[self::RELATIONSHIP]);
        unset($data[self::INTERESTS]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => null,
            self::INTERESTS => null
        ]);
    }

    public function cannot_create_profile_with_non_array_relationship()
    {
        $invalidData = $this->validData;
        $invalidData[self::RELATIONSHIP] = 'not-an-array';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::RELATIONSHIP]);
    }

    public function cannot_create_profile_with_non_array_interests()
    {
        $invalidData = $this->validData;
        $invalidData[self::INTERESTS] = 'not-an-array';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors([self::INTERESTS]);
    }

    public function can_create_profile_with_empty_relationship_and_interests_arrays()
    {
        $data = $this->validData;
        $data[self::RELATIONSHIP] = [];
        $data[self::INTERESTS] = [];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => json_encode([]),
            self::INTERESTS => json_encode([])
        ]);
    }

    public function can_create_profile_with_multiple_relationship_and_interests_values()
    {
        $data = $this->validData;
        $data[self::RELATIONSHIP] = ['inilniri', 'prieteni', 'casatorie'];
        $data[self::INTERESTS] = ['calatorii', 'filme', 'muzica', 'sport'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => json_encode($data[self::RELATIONSHIP]),
            self::INTERESTS => json_encode($data[self::INTERESTS])
        ]);
    }

    public function can_create_profile_with_duplicate_values_in_relationship_and_interests()
    {
        $data = $this->validData;
        $data[self::RELATIONSHIP] = ['inilniri', 'inilniri', 'prieteni'];
        $data[self::INTERESTS] = ['calatorii', 'calatorii', 'filme'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => json_encode($data[self::RELATIONSHIP]),
            self::INTERESTS => json_encode($data[self::INTERESTS])
        ]);
    }

    public function can_create_profile_with_special_characters_in_relationship_and_interests()
    {
        $data = $this->validData;
        $data[self::RELATIONSHIP] = ['înțelegere', 'prietenie'];
        $data[self::INTERESTS] = ['călătorii', 'filme'];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::RELATIONSHIP => json_encode($data[self::RELATIONSHIP]),
            self::INTERESTS => json_encode($data[self::INTERESTS])
        ]);
    }

    public function can_create_profile_with_preference_age()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::PREFERENCE_AGE] = json_encode([
            'min' => '18',
            'max' => '25'
        ]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::PREFERENCE_AGE => json_encode([
                'min' => '18',
                'max' => '25'
            ])
        ]);
    }

    public function can_create_profile_without_preference_age()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::PREFERENCE_AGE]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::PREFERENCE_AGE => null
        ]);
    }

    public function cannot_create_profile_with_invalid_preference_age_format()
    {
        $invalidData = $this->validData;
        $invalidData[self::PREFERENCE_AGE] = 'invalid-json';
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500);
    }

    public function cannot_create_profile_with_missing_preference_age_fields()
    {
        $invalidData = $this->validData;
        $invalidData[self::PREFERENCE_AGE] = json_encode([
            'min' => '18'
            // missing max
        ]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Preference age must contain min and max values'
            ]);
    }

    public function cannot_create_profile_with_invalid_preference_age_values()
    {
        $invalidData = $this->validData;
        $invalidData[self::PREFERENCE_AGE] = json_encode([
            'min' => '17',
            'max' => '25'
        ]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Invalid preference age values. Min and max must be between 18 and 100, and min must be less than or equal to max'
            ]);
    }

    public function cannot_create_profile_with_preference_age_min_greater_than_max()
    {
        $invalidData = $this->validData;
        $invalidData[self::PREFERENCE_AGE] = json_encode([
            'min' => '25',
            'max' => '18'
        ]);
        $invalidData[self::EMAIL] = 'test' . uniqid() . '@example.com';

        $response = $this->makeCreateProfileRequest($invalidData);
        
        $response->assertStatus(500)
            ->assertJson([
                'error' => 'An error occurred while creating the profile.',
                'message' => 'Invalid preference age values. Min and max must be between 18 and 100, and min must be less than or equal to max'
            ]);
    }

    public function can_create_profile_with_valid_preference_age_values()
    {
        $validAgeRanges = [
            ['min' => '18', 'max' => '25'],
            ['min' => '25', 'max' => '35'],
            ['min' => '35', 'max' => '45'],
            ['min' => '45', 'max' => '55']
        ];
        
        foreach ($validAgeRanges as $ageRange) {
            $data = $this->validData;
            $data[self::PREFERENCE_AGE] = json_encode($ageRange);
            $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
            
            $response = $this->makeCreateProfileRequest($data);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'token'
                ]);

            $this->assertDatabaseHas('profile_match', [
                self::PREFERENCE_AGE => json_encode($ageRange)
            ]);
        }
    }

    public function can_create_profile_with_preference_age_as_array()
    {
        $data = $this->validData;
        $data[self::PREFERENCE_AGE] = [
            'min' => '18',
            'max' => '25'
        ];
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_match', [
            self::PREFERENCE_AGE => json_encode($data[self::PREFERENCE_AGE])
        ]);
    }

    public function can_create_profile_with_valid_images()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            0 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=',
            1 => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseHas('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function can_create_profile_without_images()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        unset($data[self::IMAGES]);
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseMissing('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function cannot_create_profile_with_invalid_image_format()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            0 => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseMissing('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function cannot_create_profile_with_invalid_image_data()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            0 => 'invalid-base64-data'
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseMissing('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function cannot_create_profile_with_invalid_image_id()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            6 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k='
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseMissing('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function can_create_profile_with_multiple_valid_images()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            0 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=',
            1 => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==',
            2 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k='
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseCount('profile_images', 3);
        $this->assertDatabaseHas('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function can_create_profile_with_mixed_valid_and_invalid_images()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            0 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=',
            1 => 'invalid-base64-data',
            2 => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseCount('profile_images', 2);
        $this->assertDatabaseHas('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }

    public function can_create_profile_with_images_in_different_positions()
    {
        $data = $this->validData;
        $data[self::EMAIL] = 'test' . uniqid() . '@example.com';
        $data[self::IMAGES] = [
            2 => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAAIAAoDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAb/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCdABmX/9k=',
            4 => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='
        ];
        
        $response = $this->makeCreateProfileRequest($data);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'token'
            ]);

        $this->assertDatabaseCount('profile_images', 2);
        $this->assertDatabaseHas('profile_images', [
            'profile_id' => $response->json('token')
        ]);
    }
}