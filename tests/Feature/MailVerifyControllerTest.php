<?php

namespace Tests\Feature;

use App\Models\ProfileCredential;
use App\Mapping\FieldsMapping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailVerifyControllerTest extends TestCase
{
    use RefreshDatabase;
    use FieldsMapping;

    public function test_verify_returns_true_for_existing_email()
    {
        ProfileCredential::factory()->create([self::EMAIL => 'test@example.com']);
        $response = $this->getJson('/api/mail-verify?email=test@example.com');

        $response->assertStatus(200)
            ->assertJson(['exists' => 'true']);
    }

    public function test_verify_returns_false_for_non_existent_email()
    {
        $response = $this->getJson('/api/mail-verify?email=nonexistent@example.com');

        $response->assertStatus(200)
            ->assertJson(['exists' => 'false']);
    }

    public function test_verify_returns_false_when_email_missing()
    {
        $response = $this->getJson('/api/mail-verify');

        $response->assertStatus(200)
            ->assertJson(['exists' => 'false']);
    }

    public function test_verify_is_case_sensitive()
    {
        ProfileCredential::factory()->create([self::EMAIL => 'test@example.com']);
        $response = $this->getJson('/api/mail-verify?email=TEST@EXAMPLE.COM');

        $response->assertStatus(200)
            ->assertJson(['exists' => 'false']); // Expect case-sensitivity
    }
}