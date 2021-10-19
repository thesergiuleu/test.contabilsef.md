<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Services\Pages\SingleCategoryPageService;
use App\Services\Pages\SinglePostPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(): JsonResponse
    {
        $posts = Category::query()->paginate();

        return $this->responseOk($posts);
    }

    public function show($slug): array
    {
        $category = Category::whereSlug($slug)->firstOrFail();

        /** @var SingleCategoryPageService $singleCategoryPageService */
        $singleCategoryPageService = app()->make(SingleCategoryPageService::class);
        $singleCategoryPageService->setCategory($category);

        return $singleCategoryPageService->getPage();
    }

    public function getCategoryChildren($slug): JsonResponse
    {
        $category = Category::whereSlug($slug)->firstOrFail();
        return $this->responseOk($category->children()->paginate());
    }
}
