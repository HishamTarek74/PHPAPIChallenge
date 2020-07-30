<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;


class LogoutTest extends TestCase
{

    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'marquise.lakin@gmail.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('post', '/api/v1/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->access_token);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create(['email' => 'marquise.lakin@gmail.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        $user->access_token = null;
        $user->save();

        $this->json('get', "/api/userposts/$user->id", [], $headers)->assertStatus(401);
    }
}
