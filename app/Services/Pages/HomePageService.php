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
        $topData = new GeneralCollection(Post::instruire()->limit(5)->get());
        $contabilSefData = new GeneralCollection(Post::query()->limit(5)->get());
        $newsData = new GeneralCollection(Post::query()->limit(5)->get());
        $articlesData = new GeneralCollection(Post::query()->limit(5)->get());

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
                        'with_external_author' => true,
                        'with_see_more' => true,
                        'grid' => true
                    ]),
                    $this->getSection('Noutăți', 'posts', $newsData, [
                        'is_name_displayed' => true,
                        'with_header' => true,
                        'with_images' => true,
                        'with_date' => true,
                        'with_external_author' => true,
                        'with_excerpt' => true,
                        'with_see_more' => true
                    ]),
                    $this->getSection('Articole', 'posts', $articlesData, [
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
