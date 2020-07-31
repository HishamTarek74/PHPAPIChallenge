<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Symfony\Component\HttpFoundation\Response;


class PostController extends Controller
{
    public function __construct()
    {
     $this->middleware('auth:api')->except(['index', 'show']);
    }
 
     /**
      * Display all Posts that have been added
      *
      * @return \Illuminate\Http\Response
      */
     public function index($id)
     {
        $post = Post::findOrFail($id);
        return new PostResource($post);

     }
   /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(StorePostRequest $request)
     {
         $post = Post::create($request->all());

        return (new PostResource($post))
          ->response()
          ->setStatusCode(Response::HTTP_CREATED);
 }
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show(Post $post)
     {
         return new PostResource($post);
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(UpdatePostRequest $request, Post $post)
 
     {
 
       // check if currently authenticated user is the owner of the Post
 
       if ($request->user()->id !== $post->user_id) {
 
         return response()->json(['error' => 'You can only edit your own Posts.'], 403);
 
       }
 
       $post->update($request->all());

       return (new PostResource($post))
           ->response()
           ->setStatusCode(Response::HTTP_ACCEPTED); 
 
      }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Request $request,Post $post)
     {
        if($request->user()->id != $post->user_id){
          return response()->json(['error' => 'You can only delete your own Posts.'], 403);
        }
         $post ->delete();
         return response(null, Response::HTTP_NO_CONTENT);
    }
}
