<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Models\Post;

class PostsTest extends TestCase
{
    public function testsPostsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
            'post_content' => 'Ipsum',
            'author' => 'Ipsum',
            'user_id' => 1
        ];

        $this->json('POST', '/api/v1/post', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Lorem', 'body' => 'Ipsum']);
    }

    public function testsPostsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Lorem',
            'post_content' => 'Ipsum',
            'author' => 'Ipsum',
            'user_id' => 1
        ]);

        $payload = [
            'title' => 'Lorem1',
            'post_content' => 'Ipsum1',
            'author' => 'Ipsum1',
            'user_id' => 1
        ];

        $response = $this->json('PUT', '/api/v1/post/' . $post->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([ 
                'title' => 'Lorem1',
                'post_content' => 'Ipsum1',
                'author' => 'Ipsum1',
                'user_id' => 1
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $post = factory(Post::class)->create([
            'title' => 'Lorem1',
            'post_content' => 'Ipsum1',
            'author' => 'Ipsum1',
            'user_id' => 1
        ]);

        $this->json('DELETE', '/api/v1/post/' . $post->id, [], $headers)
            ->assertStatus(204);
    }

}
