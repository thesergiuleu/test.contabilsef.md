<?php


namespace App\Services;


use App\Category;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostsService implements PostsServiceInterface
{
    private $category, $sortOrder = 'desc', $sortColumn = 'created_at', $limit = 20, $posts;

    /**
     * @param mixed $category
     * @return PostsService
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @param string $sortOrder
     * @return PostsService
     */
    public function setSortOrder(string $sortOrder): PostsService
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }

    /**
     * @param string $sortColumn
     * @return PostsService
     */
    public function setSortColumn(string $sortColumn): PostsService
    {
        $this->sortColumn = $sortColumn;
        return $this;
    }

    /**
     * @param int $limit
     * @return PostsService
     */
    public function setLimit(int $limit): PostsService
    {
        $this->limit = $limit;
        return $this;
    }


    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        $this->retrievePosts();
        return $this->posts;
    }

    /**
     * @return Collection
     */
    public function getTopSeven(): Collection
    {
        $this->retrievePosts();
        return $this->posts;
    }

    /**
     * @return Collection
     */
    public function getTopThirty(): Collection
    {
        $this->retrievePosts();
        return $this->posts;
    }

    private function retrievePosts(): void
    {
        $this->category
            ? $query = Post::whereCategoryId($this->getCategoryId())
            : $query = Post::query();

        $this->posts = $query
            ->orderBy($this->sortColumn, $this->sortOrder)
            ->limit($this->limit)
            ->get();
    }

    /**
     * @return Category|Builder|Model|object|null
     */
    private function getCategoryId()
    {
        return Category::whereSlug($this->category)->first()->id ?? null;
    }
}
