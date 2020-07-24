<?php

namespace App\Services;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Database\Eloquent\Collection;

interface PostsServiceInterface
{
    /**
     * @param mixed $category
     * @return PostsService
     */
    public function setCategory($category);

    /**
     * @param string $sortOrder
     * @return PostsService
     */
    public function setSortOrder(string $sortOrder): PostsService;

    /**
     * @param string $sortColumn
     * @return PostsService
     */
    public function setSortColumn(string $sortColumn): PostsService;

    /**
     * @param int $limit
     * @return PostsService
     */
    public function setLimit(int $limit): PostsService;

    /**
     * @return Collection
     */
    public function getPosts(): Collection;
}
