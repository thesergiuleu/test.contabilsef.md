<?php


namespace App\Services;


use App\Category;
use App\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    private function retrievePosts(): void
    {
        $this->category
            ? $this->posts = $this->getCategoryPosts()
            : $this->posts = Post::query()->orderBy($this->sortColumn, $this->sortOrder)->limit($this->limit)->get();
    }

    /**
     * @return Category|Builder|Model|object|null
     */
    private function getCategoryPosts()
    {
        $category = Category::with(['posts', 'subPosts'])->where('slug', $this->category)->first();

        return $category ? $category
            ->posts()
            ->when($category->slug === Category::INSTRUIRE_CATEGORY, function (Builder $query) {
                $query->where(DB::raw('DATE(event_date)'), '>=', Carbon::now()->format('Y-m-d'));
            })
            ->orderBy($this->sortColumn, $this->sortOrder)
            ->limit($this->limit)
            ->get()
            ->merge($category
                ->subPosts()
                ->orderBy($this->sortColumn, $this->sortOrder)
                ->limit($this->limit)
                ->get()
            ) : new Collection([]);
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
}
