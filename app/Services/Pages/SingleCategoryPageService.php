<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Http\Resources\GeneralResource;

class SingleCategoryPageService extends AbstractPage
{
    /** @var Category $category */
    private $category;
    private $posts;

    public function setCategory($category): SingleCategoryPageService
    {
        $this->category = $category;
        return $this;
    }

    public function setAllPosts($posts): SingleCategoryPageService
    {
        $this->posts = $posts;
        return $this;
    }

    public function getPage(): array
    {
        $category = new GeneralResource($this->category);
        $this->setAllPosts($this->category->getAllPosts());

        return [
            'sidebar' => $this->getSidebar(),
            'main' => [
                'sections' => $this->getMainSection($category)
            ]
        ];
    }

    private function getMainSection($category): array
    {
        if ($this->posts->isNotEmpty()) {
            $meta['paginator'] = buildPaginatorMeta($this->posts);
            return [
                $this->getSection($category->name, 'posts', new GeneralCollection($this->posts), [
                    'is_name_displayed' => true,
                    'with_views' => true,
                    'with_date' => true
                ], $meta)
            ];
        }
        return [
            $this->getSection($this->category->name, 'categories', new GeneralCollection($this->category->children), [
                'is_name_displayed' => true,
            ]),
        ];
    }

    /**
     * @return array
     */
    private function getSidebar()
    {
        if ($this->posts->isNotEmpty()) {
            return [
                'sections' => [
                    $this->getSection('Banner', 'banner'),
                    $this->getSection($this->category->name, 'categories', new GeneralCollection($this->category->children), [
                        'is_name_displayed' => true,
                    ]),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ];
        }
        if ($this->category->children->isEmpty()) {
            return [
                'sections' => [
                    $this->getSection('Banner', 'banner'),
                    $this->getSection('Calendar', 'calendar', $this->getCalendarData()),
                ]
            ];
        }

        return null;
    }
}
