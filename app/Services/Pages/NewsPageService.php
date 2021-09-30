<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class NewsPageService extends AbstractPage
{

    public function getPage(): array
    {
        $parent = Category::whereSlug(Category::NEWS_CATEGORY)->first();
        $newsCategoriesData =  $parent ? new GeneralCollection(Category::whereParentId($parent->id)->get()) : [];

        return [
            'sidebar' => null,
            'main' => [
                'sections' => [
                    $this->getSection('Noutăți', 'categories', $newsCategoriesData, [
                        'is_name_displayed' => true,
                    ])
                ]
            ]
        ];
    }
}
