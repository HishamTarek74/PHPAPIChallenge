<?php

namespace Tests\Feature;
use App\Http\Resources\UserCollectionResource;

use App\User;
use App\Models\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;
    //Its Tests Cases For Admin
    public function it_git_all_users() {

        $users = factory(User::class,2)->create();
        foreach($users as $user) {

            $user->posts()->saveMany(factory(Post::class,2)->create()->make());
        }

        $response = $this->get(route('users.index'));
        $response->assertResource(UserCollectionResource::collection($users));

    }
 
 //Its Tests Cases For User
    public function testsUsersAreUpdatedCorrectly()

    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'Lorem1',
            'email' => 'Ipsum1',
            'password' => 'Ipsum1',
        ];

        $response = $this->json('PUT', '/api/v1/users/' . $user->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
                'name' => 'Lorem1',
                'email' => 'Ipsum1',
                'password' => 'Ipsum1',
            ]);
    }

}
