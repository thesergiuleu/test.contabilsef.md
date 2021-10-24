<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsStoreRequest;
use App\Post;
use Illuminate\Database\Eloquent\Collection;

class CommentsController extends Controller
{
    public function getPostComments(Post $post): Collection
    {
        return $post->comments()->with('children')->get();
    }


    public function addComment(CommentsStoreRequest $request, Post $post): Collection
    {
        $data = $request->validated();

        $post->comments()->create($data);

        return $post->comments()->with('children')->get();
    }
}
