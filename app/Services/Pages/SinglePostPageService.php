<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralResource;
use App\Post;

class SinglePostPageService extends AbstractPage
{
    /** @var Post $post */
    private $post;

    public function setPost($post): SinglePostPageService
    {
        $this->post = $post;
        return $this;
    }

    public function getPage(): array
    {
        $post = new GeneralResource($this->post);
        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Banner', 'banner'),
                    $this->getSection('Similar din aceiași categorie', 'posts', $this->post->category->getPosts()->limit(10)->get(), [
                        'is_name_displayed' => true,
                        'with_see_more' => true
                    ]),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ],
            'main' => [
                'sections' => $this->getSinglePostMainSections($post)
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
