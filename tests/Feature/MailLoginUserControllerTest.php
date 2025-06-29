<?php

namespace Tests\Feature;

use App\Models\ProfileCredential;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MailLoginUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_successful()
    {
        $plainPassword = '123qwe!@#QWE';
        $user = ProfileCredential::factory()->create([
            'email' => 'z@example.com',
            'password' => bcrypt($plainPassword),
        ]);

        $response = $this->postJson('/api/login-user', [
            'email' => 'z@example.com',
            'password' => $plainPassword,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_login_fails_with_incorrect_password()
    {
        $plainPassword = '123qwe!@#QWE';
        $user = ProfileCredential::factory()->create([
            'email' => 'z@example.com',
            'password' => bcrypt($plainPassword),
        ]);

        $response = $this->postJson('/api/login-user', [
            'email' => 'z@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(403)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Credențiale invalide.']);
    }

    public function test_login_fails_with_non_existent_user()
    {
        $response = $this->postJson('/api/login-user', [
            'email' => 'nonexistent@example.com',
            'password' => '123qwe!@#QWE',
        ]);

        $response->assertStatus(403)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Credențiale invalide.']);
    }

    public function test_login_fails_with_empty_credentials()
    {
        $response = $this->postJson('/api/login-user', []);

        $response->assertStatus(400)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Email și parola sunt obligatorii.']);
    }

    public function test_login_fails_with_case_sensitive_email()
    {
        $plainPassword = '123qwe!@#QWE';
        $user = ProfileCredential::factory()->create([
            'email' => 'z@example.com',
            'password' => bcrypt($plainPassword),
        ]);

        $response = $this->postJson('/api/login-user', [
            'email' => 'Z@EXAMPLE.COM',
            'password' => $plainPassword,
        ]);

        $response->assertStatus(403)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Credențiale invalide.']);
    }

    public function test_login_fails_with_excessively_long_password()
    {
        $plainPassword = '123qwe!@#QWE';
        $user = ProfileCredential::factory()->create([
            'email' => 'z@example.com',
            'password' => bcrypt($plainPassword),
        ]);

        $longPassword = str_repeat('a', 256);
        $response = $this->postJson('/api/login-user', [
            'email' => 'z@example.com',
            'password' => $longPassword,
        ]);

        $response->assertStatus(403)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Credențiale invalide.']);
    }

    public function test_login_fails_with_malformed_json()
    {
        // Simulate malformed JSON
        $malformedJson = '{email: "z@example.com", "password": "123qwe!@#QWE"'; // Missing quotes around 'email'
        $response = $this->call('POST', '/api/login-user', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], $malformedJson);

        $response->assertStatus(400)
            ->assertJsonStructure(['message'])
            ->assertJson(['message' => 'Email și parola sunt obligatorii.']); // Match current behavior
    }
}