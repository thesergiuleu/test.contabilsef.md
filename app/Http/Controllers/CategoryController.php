<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryController extends SiteBaseController
{
    public function view($slug)
    {
        $item = Category::whereSlug($slug)->firstOrFail();

        $this->getCategoryData($item);

        if ($item->children()->exists())
            $this->getCategoryDataForParent($item);

        return view('single', $this->viewData);
    }

    /**
     * @param Category $item
     */
    private function getCategoryDataForParent(Category $item): void
    {
        $sidebar = [
            $this->componentService
                ->setName('components.sidebar.category-side-block')
                ->setData($item)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];

        $components = [
            $this->componentService
                ->setName('components.categories-block')
                ->setData($item)
                ->build()
        ];

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $components),
            $this->addSection('sections.top-sidebar', $sidebar),
        ];
    }

    /**
     * @param Category $item
     */
    private function getCategoryData(Category $item)
    {
        $posts = $item->posts()
            ->where(function (Builder $query) {
                foreach ($this->filters as $key => $filter) {
                    if ($key == 'year') {
                        $query = $query->whereYear('created_at', $filter);
                    }
                    if ($key == 'month') {
                        $query = $query->whereMonth('created_at', $filter);
                    }
                    if ($key == 'status') {
                        $query = $query->where('privacy', self::$status[$filter]);
                    }
                }
            })
            ->paginate(2);

        $sidebar = [
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($posts)
                ->setTitle($item->name)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];

        $components = [
            $this->componentService
                ->setName('components.banner')
                ->setData([1,2])
                ->build(),
            $this->componentService
                ->setName('components.articles-block')
                ->setData($posts)
                ->setRoute(route('category.view', $item->slug))
                ->build([
                    'date' => true,
                    'views' => true,
                ]),
        ];

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $components),
            $this->addSection('sections.top-sidebar', $sidebar),
        ];
    }
}
