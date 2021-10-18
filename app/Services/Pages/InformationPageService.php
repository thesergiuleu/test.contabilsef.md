<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class InformationPageService extends AbstractPage
{
    public function getPage(): array
    {
        $categories = new GeneralCollection(Category::whereNull('parent_id')->whereNotIn('slug', Category::NAV_BAR_PARENT_CATEGORIES)->get());

        return [
            'sidebar' => null,
            'main' => [
                'sections' => [
                    $this->getSection('Informaţii utile', 'categories', $categories, [
                        'is_name_displayed' => true,
                        'grid' => true
                    ])
                ]
            ]
        ];
    }
}
