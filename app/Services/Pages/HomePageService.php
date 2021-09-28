<?php

namespace App\Services\Pages;

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
                        'is_name_displayed' => false,
                        'type' => 'categories',
                        'data' => [],
                        'config' => []
                    ],
                    [
                        'name' => 'Top cele mai citite',
                        'type' => 'posts',
                        'is_name_displayed' => true,
                        'data' => [],
                        'config' => []
                    ],
                    [
                        'name' => 'Calendar',
                        'type' => 'calendar',
                        'is_name_displayed' => false,
                        'data' => new InstruireCalendarCollection(Post::instruire()->limit(5)->get()),
                        'config' => []
                    ]
                ]
            ],
            'main' => [
                'sections' => [
                    [
                        'name' => 'Banner',
                        'is_name_displayed' => false,
                        'type' => 'banner',
                        'data' => [],
                        'config' => []
                    ],
                    [
                        'name' => 'Contabil Șef',
                        'type' => 'posts',
                        'data' => new InstruireCalendarCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true
                        ]
                    ],
                    [
                        'name' => 'Noutăți',
                        'is_name_displayed' => true,
                        'type' => 'posts',
                        'data' => new InstruireCalendarCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => true
                        ]
                    ],
                    [
                        'name' => 'Articole',
                        'is_name_displayed' => true,
                        'type' => 'posts',
                        'data' => new InstruireCalendarCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'grid' => false,
                            'with_header' => true,
                            'with_images' => false
                        ]
                    ]
                ]
            ]
        ];
    }
}
