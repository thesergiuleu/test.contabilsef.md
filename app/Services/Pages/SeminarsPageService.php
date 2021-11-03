<?php

namespace App\Services\Pages;

use App\Banner;
use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;

class SeminarsPageService extends AbstractPage
{

    public function getPage(): array
    {
        $seminarsData = new GeneralCollection(Post::instruire()->paginate());

        return [
            'sidebar' => null,
            'main' => [
                'sections' => [
                    $this->getSection('Seminare', 'posts', $seminarsData, [
                        'is_name_displayed' => true,
                        'grid' => true,
                        'with_images' => true,
                        'with_external_author' => true,
                        'with_date' => true,
                        'with_filters' => true,
                    ])
                ]
            ]
        ];
    }
}
