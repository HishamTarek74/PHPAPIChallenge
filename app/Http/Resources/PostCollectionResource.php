<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

      //  return parent::toArray($request);
      return $this->collection->transform(function ($post) {

       return [
            'id' => $post->id,
            'name' => $post->name,
            'post_content' =>$post->post_content,
            'author' => $post->author,
            'user_id' => $post->user_id,
            'user' => $post->user


        ];

      });
        

    }
}
