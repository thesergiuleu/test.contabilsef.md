<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\InstruireCalendarCollection;
use App\Post;

class HomePageService implements PageInterface
{
    public function getPage(): array
    {
        return [
            'sidebar' => [
                'sections' => [
                    [
                        'name' => 'Link-uri utile',
                        'type' => 'categories',
                        'data' => [],
                        'config' => [
                            'is_name_displayed' => false,
                            'grid' => false,
                            'with_header' => false,
                            'with_images' => false,
                            'with_date' => false,
                            'with_external_author' => false,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => false
                        ]
                    ],
                    [
                        'name' => 'Noutăți',
                        'type' => 'categories',
                        'data' => new GeneralCollection(Category::whereParentId(Category::whereSlug(Category::NEWS_CATEGORY)->first()->id)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => false,
                            'with_images' => false,
                            'with_date' => false,
                            'with_external_author' => false,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => false
                        ]
                    ],
                    [
                        'name' => 'Top cele mai citite',
                        'type' => 'posts',
                        'data' => new GeneralCollection(Post::instruire()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => false
                        ]
                    ],
                    [
                        'name' => 'Calendar',
                        'type' => 'calendar',
                        'data' => new GeneralCollection(Post::instruire()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => false,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => false
                        ]
                    ]
                ]
            ],
            'main' => [
                'sections' => [
                    [
                        'name' => 'Banner',
                        'type' => 'banner',
                        'data' => [],
                        'config' => [
                            'is_name_displayed' => false,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => false
                        ]
                    ],
                    [
                        'name' => 'Contabil Șef',
                        'type' => 'posts',
                        'data' => new GeneralCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => true
                        ]
                    ],
                    [
                        'name' => 'Noutăți',
                        'type' => 'posts',
                        'data' => new GeneralCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => false,
                            'with_comments_count' => false,
                            'with_privacy' => false,
                            'with_category' => false,
                            'with_excerpt' => true
                        ]
                    ],
                    [
                        'name' => 'Articole',
                        'type' => 'posts',
                        'data' => new GeneralCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true,
                            'with_date' => true,
                            'with_external_author' => true,
                            'with_views' => true,
                            'with_comments_count' => true,
                            'with_privacy' => true,
                            'with_category' => true,
                            'with_excerpt' => true
                        ]
                    ]
                ]
            ]
        ];
    }
}
