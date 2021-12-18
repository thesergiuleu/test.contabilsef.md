<?php

namespace App\Services\Pages;

use App\Banner;
use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Page;
use App\Post;
use App\SubscriptionService;
use Illuminate\Support\Collection;

class HomePageService extends AbstractPage
{
    public function getPage(): array
    {
        $newsCategoriesData = new GeneralCollection(Category::whereParentId(Category::whereSlug(Category::NEWS_CATEGORY)->first()->id)->get());
        $topData = new GeneralCollection(Post::query()->orderByDesc('views')->limit(7)->get());
        $contabilSefData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::CONTABIL_SEF_NEWS_CATEGORY)->first()->id)->limit(6)->get());
        $newsData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::GENERAL_NEWS_CATEGORY)->first()->id)->limit(6)->get());
        $articlesData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::GENERAL_NEWS_CATEGORY)->first()->id)->orderByDesc('id')->limit(6)->get());

        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Link-uri utile', 'categories', $this->getLinks()),
                    $this->getSection('Noutăți', 'categories', $newsCategoriesData, [
                        'is_name_displayed' => true
                    ]),
                    $this->getSection('Top cele mai citite', 'posts', $topData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                    ]),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ],
            'main' => [
                'sections' => [
                    $this->getSection('Banner', 'banner', Banner::getBanners(Banner::POSITION_MAIN_TOP)),
                    $this->getSection('Contabil Șef', 'posts', $contabilSefData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true,
                        'with_views' => true,
                        'with_comments_count' => true,
                        'with_privacy' => true,
                        'with_category' => true,
                        'with_grid' => true
                    ], [
                        'see_more_link' => buildSeeMoreLink('categories', Category::CONTABIL_SEF_NEWS_CATEGORY)
                    ]),
                    $this->getSection('Noutăți', 'posts', $newsData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_views' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true,
                        'with_comments_count' => true,
                    ], [
                        'see_more_link' => buildSeeMoreLink('categories', Category::GENERAL_NEWS_CATEGORY)
                    ]),
                    $this->getSection('Articole', 'posts', $articlesData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true,
                        'with_views' => true,
                        'with_comments_count' => true,
                        'with_privacy' => true,
                        'with_category' => true,
                    ], [
                        'see_more_link' => buildSeeMoreLink('categories', Category::GENERAL_NEWS_CATEGORY)
                    ])
                ]
            ]
        ];
    }

    private function getLinks(): GeneralCollection
    {
        $collection = new Collection();
        $collection->push(new Post([
            'id' => 1,
            'external_link' => config('app.front_url') . "/service/" . SubscriptionService::query()->orderBy('created_at')->first()->id,
            'name' => 'Revista electronică ”Contabilsef.md”',
        ]));
        $collection->push(Category::whereSlug(Category::SNC_2020_CATEGORY)->first());
        $collection->push(Category::whereSlug(Category::INDICATORI_FISCALI_CATEGORY)->first());
//        $collection->push(Page::whereSlug(Page::CONSULTANT_SNC)->first());
        $collection->push(Category::whereSlug(Category::SINTEZA_MONITORULUI_OFICIAL_CATEGORY)->first());
        return new GeneralCollection($collection);
    }
}
