<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{


    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/v1/login')
            ->assertStatus(422)
            ->assertJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        // $user = factory(User::class)->create([
        //     'email' => 'marquise.lakin@gmail.com',
        //     'name' => "Hisham",
        //     'password' => bcrypt('11111111'),
        // ]);

        $payload = ['email' => 'marquise.lakin@gmail.com', 'password' => '11111111'];

        $this->json('POST', 'api/v1/login', $payload)
            ->assertStatus(200)
            ->assertJson([

                'access_token',
                'token_type',
                'expires_in',

            ]);

    }
}
