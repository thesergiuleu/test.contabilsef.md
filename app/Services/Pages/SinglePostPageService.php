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
        /** @var Collection $similarData */
        $similarData = $this->post->category->getPosts()->where('id', '!=', $this->post->id)->limit(10)->get();
        $bannerData = Banner::getBanners(Banner::POSITION_INDIVIDUAL);
        $similarSection = $this->getSection('Similar din aceiași categorie', 'posts', $similarData, [
            'is_name_displayed' => true,
            'with_see_more' => $similarData->isNotEmpty()
        ], ['see_more_link' => buildSeeMoreLink('categories', $this->post->category->slug)]);
        $bannerSection = $this->getSection('Banner', 'banner', $bannerData);
        return [
            'sidebar' => [
                'sections' => array_values(array_filter([
                    !empty($bannerData) ? $bannerSection : null,
                    $similarData->isNotEmpty() ? $similarSection : null,
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]))
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
                'with_date' => true,
                'with_external_author' => true,
                'with_comments_count' => true,
                'with_privacy' => true,
                'with_category' => true,

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
