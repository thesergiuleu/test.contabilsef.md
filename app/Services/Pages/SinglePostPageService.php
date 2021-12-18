<?php

namespace App\Services\Pages;

use App\Banner;
use App\Category;
use App\Http\Resources\GeneralResource;
use App\Post;
use Illuminate\Database\Eloquent\Collection;

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
        /** @var Collection $similar */
        $similar = $this->post->category->getPosts()->where('id', '!=', $this->post->id)->limit(10)->get();
        $section = $this->getSection('Similar din aceiași categorie', 'posts', $similar, [
            'is_name_displayed' => true,
            'with_see_more' => $similar->isNotEmpty()
        ], ['see_more_link' => buildSeeMoreLink('categories', $this->post->category->slug)]);
        return [
            'sidebar' => [
                'sections' => [
                    $this->getSection('Banner', 'banner', Banner::getBanners(Banner::POSITION_INDIVIDUAL)),
                    $similar->isNotEmpty() ? $section : null,
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

        array_push($sections, $section);

        return $sections;
    }
}
