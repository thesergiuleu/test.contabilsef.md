<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class AboutPageService extends AbstractPage
{

    public function getPage(): array
    {
        $parent = Category::whereSlug(Category::DESPRE_NOI)->first();
        $aboutUsCategories =  $parent ? new GeneralCollection(Category::whereParentId($parent->id)->get()) : [];
        $calendarData = new GeneralCollection(Post::instruire()->limit(5)->get());

        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Despre', 'categories', $aboutUsCategories, [
                        'is_name_displayed' => true,
                    ]),
                    $this->getSection('Calendar', 'calendar', $calendarData),
                ]
            ],
            'main' => null
        ];
    }
}
