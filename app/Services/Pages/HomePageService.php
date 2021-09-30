<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class HomePageService implements PageInterface
{
    public function getPage(): array
    {
        $newsCategoriesData =  new GeneralCollection(Category::whereParentId(Category::whereSlug(Category::NEWS_CATEGORY)->first()->id)->get());
        $topData = new GeneralCollection(Post::instruire()->limit(5)->get());
        $calendarData = new GeneralCollection(Post::instruire()->limit(5)->get());
        $contabilSefData = new GeneralCollection(Post::query()->limit(5)->get());
        $newsData = new GeneralCollection(Post::query()->limit(5)->get());
        $articlesData = new GeneralCollection(Post::query()->limit(5)->get());

        return [
            'sidebar' => [
                'sections' => [
                    getSection('Link-uri utile', 'categories'),
                    getSection('Noutăți', 'categories', $newsCategoriesData, [
                        'is_name_displayed' => true
                    ]),
                    getSection('Top cele mai citite', 'posts', $topData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                    ]),
                    getSection('Calendar', 'calendar', $calendarData),
                ]
            ],
            'main' => [
                'sections' => [
                    getSection('Banner', 'banner'),
                    getSection('Contabil Șef', 'posts', $contabilSefData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true
                    ]),
                    getSection('Noutăți', 'posts', $newsData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true
                    ]),
                    getSection('Articole', 'posts', $articlesData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true
                    ])
                ]
            ]
        ];
    }
}
