<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Category::query()->paginate();

        return $this->responseOk($posts);
    }

    public function show($slug): JsonResponse
    {
        $category = Category::whereSlug($slug)->firstOrFail();

        return $this->responseOk($category);
    }

    public function getCategoryChildren($slug): JsonResponse
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        return $this->responseOk($category->children()->paginate());
    }
}
