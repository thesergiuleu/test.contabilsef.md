<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsStoreRequest;
use App\Post;

class CommentsController extends Controller
{
    public function store(CommentsStoreRequest $request, Post $post)
    {
        $data = $request->validated();

        $post->comments()->create($data);

        return response()->json([
            'message' => setting('raspunsuri.comment_store', 'Comentariul dumneavoastra se proceseaza.'),
            'status' => 'success',
            'redirect_url' => $post->post_url
        ]);
    }
}
