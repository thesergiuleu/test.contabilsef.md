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
                        'type' => 'categories',
                        'data' => [],
                        'config' => [
                            'is_name_displayed' => false,
                        ]
                    ],
                    [
                        'name' => 'Top cele mai citite',
                        'type' => 'posts',
                        'data' => [],
                        'config' => [
                            'is_name_displayed' => true,
                        ]
                    ],
                    [
                        'name' => 'Calendar',
                        'type' => 'calendar',
                        'data' => new InstruireCalendarCollection(Post::instruire()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => false,
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
                        ]
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
                        'name' => 'Articole',
                        'type' => 'posts',
                        'data' => new InstruireCalendarCollection(Post::query()->limit(5)->get()),
                        'config' => [
                            'is_name_displayed' => true,
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
