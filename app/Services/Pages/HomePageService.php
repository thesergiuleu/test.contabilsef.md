<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class HomePageService extends AbstractPage
{
    public function getPage(): array
    {
        $newsCategoriesData =  new GeneralCollection(Category::whereParentId(Category::whereSlug(Category::NEWS_CATEGORY)->first()->id)->get());
        $topData = new GeneralCollection(Post::query()->orderByDesc('views')->limit(7)->get());
        $contabilSefData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::CONTABIL_SEF_NEWS_CATEGORY)->first()->id)->limit(6)->get());
        $newsData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::CONTABIL_SEF_NEWS_CATEGORY)->first()->id)->limit(6)->get());
        $articlesData = new GeneralCollection(Post::query()->where('category_id', Category::whereSlug(Category::ARTICLES_CATEGORY)->first()->id)->limit(6)->get());

        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Link-uri utile', 'categories'),
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
                    $this->getSection('Banner', 'banner'),
                    $this->getSection('Contabil Șef', 'posts', $contabilSefData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_see_more' => true,
                        'grid' => true,
                        'with_views' => true
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
                        'with_privacy' => true
                    ])
                ]
            ]
        ];
    }
}
