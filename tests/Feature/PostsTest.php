<?php

namespace Tests\Feature;
use App\Http\Resources\PostCollectionResource;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Models\Post;

class PostsTest extends TestCase
{
    use DatabaseMigrations;


    //Its Tests Cases For Admin
    public function it_git_all_posts() {

        $posts = factory(Post::class,2)->create();
        foreach($posts as $posts) {

            $posts->user()->saveOne(factory(User::class,2)->create()->make());
        }

        $response = $this->get(route('posts.index'));
        $response->assertResource(PostCollectionResource::collection($posts));

    }

    //Its Tests Cases For User
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

    public function testsPostsAreDeletedCorrectly()
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
