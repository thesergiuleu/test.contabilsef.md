<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentsStoreRequest;
use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    public function getPostComments(Post $post): JsonResponse
    {
        return responseSuccess($post->comments()->with('children')->get(), "Lista de comentarii");
    }


    public function addComment(CommentsStoreRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();

        $post->comments()->create($data);

        return responseSuccess($post->comments()->with('children')->get(), "Comentariul a fost adaugat cu success, si va fi afișat după verificarea noastră.");
    }
}
