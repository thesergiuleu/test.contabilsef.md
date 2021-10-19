<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralResource;
use App\Post;

class SingleCategoryPageService extends AbstractPage
{
    /** @var Category $category */
    private $category;

    public function setCategory($category): SingleCategoryPageService
    {
        $this->category = $category;
        return $this;
    }

    public function getPage(): array
    {
        dd($this->category);
        $category = new GeneralResource($this->category);
        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Banner', 'banner'),
                    $this->getSection('Similar din aceiași categorie', 'posts', $this->category->getPosts()->where('id', '!=', $this->category->id)->limit(10)->get(), [
                        'is_name_displayed' => true,
                        'with_see_more' => true
                    ]),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ],
            'main' => [
                'sections' => $this->getSinglePostMainSections($category)
            ]
        ];
    }

    private function getSinglePostMainSections($post): array
    {
        $sections = [
            $this->getSection($post->title, 'post', $post, [
                'is_name_displayed' => true,
                'with_views' => true,
                'with_date' => true
            ])
        ];

        if ($post->category->slug == Category::INSTRUIRE) {
            $section = $this->getSection('Înregistrare la seminar', 'seminar_register_form', [], [
                'is_name_displayed' => true
            ]);
        } else {
            $section = $this->getSection('Comentarii', 'comments_form', $post->comments, [
                'is_name_displayed' => true
            ]);
        }

        array_push($sections,$section);

        return $sections;
    }
}
