<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends SiteBaseController
{
    public function view($slug)
    {
        if ($slug == Category::GLOSARY_CATEGORY) {
            return redirect()->route('glossary.index');
        }

        $item = Category::whereSlug($slug)->firstOrFail();


        $this->getCategoryData($item);

        if ($item->children()->exists())
            $this->getCategoryDataForParent($item);

        $breadCrumbs = [];
        if ($item->parent_category->id != $item->id) {
            $breadCrumbs = [
                route('category.view', $item->parent_category->slug) => $item->parent_category->name
            ];
        }

        $this->viewData['breadCrumbs'] = array_merge($breadCrumbs, [
            route('category.view', $item->slug) => $item->name
        ]);

        return view('single', $this->viewData);
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
            ->when($item->slug === Category::INSTRUIRE_CATEGORY, function (Builder $query) {
                $query
                    ->where(DB::raw('DATE(event_date)'), '>=', Carbon::now()->format('Y-m-d'))
                    ->orderBy('event_date');
            })
            ->paginate(5);

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $this->getComponents($posts, $item)),
            $this->addSection('sections.top-sidebar', $this->getSidebarComponents($posts, $item)),
        ];
    }

    /**
     * @param $posts
     * @param Category $item
     * @return array
     */
    private function getComponents($posts, Category $item): array
    {
        return [
            $this->componentService
                ->setName('components.banner')
                ->setData(Banner::getBanners(Banner::POSITION_INDIVIDUAL))
                ->build(),
            $this->componentService
                ->setName('components.articles-block')
                ->setData($posts)
                ->setRoute(route('category.view', $item->slug))
                ->build([
                    'date' => true,
                    'views' => true,
                    'comments_count' => true,
                    'lock' => true,
                    'link' => true,
                ]),
        ];
    }

    /**
     * @param $posts
     * @param Category $item
     * @return array
     */
    private function getSidebarComponents($posts, Category $item): array
    {
        return [
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($posts)
                ->setTitle($item->name)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];
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
}
