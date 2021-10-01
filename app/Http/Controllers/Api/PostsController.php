<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use App\Services\Pages\SinglePostPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Post::query()->paginate();

        return $this->responseOk($posts);
    }

    public function show($slug): array
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        /** @var SinglePostPageService $singlePostPageService */
        $singlePostPageService = app()->make(SinglePostPageService::class);
        $singlePostPageService->setPost($post);
        return $singlePostPageService->getPage();
    }

    public function getPostsByCategorySlug($slug): JsonResponse
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        return $this->responseOk($category->getPosts()->paginate());
    }
}
