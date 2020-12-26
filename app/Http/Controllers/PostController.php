<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Post;

class PostController extends SiteBaseController
{
    public function view($categorySlug, $slug)
    {
        $this->viewData['classes'] = 'lista-de-articole management';
        if ($categorySlug == Category::INSTRUIRE_CATEGORY) {
            $this->viewData['classes'] .= ' unSeminar';
        }
        $category = Category::whereSlug($categorySlug)->firstOrFail();

        $item = $category->posts()->where('slug', $slug)->firstOrFail();

        $this->viewData['classes'] .= ' Informatie-cu-plata';
        $item->views += 1;
        $item->save();

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $this->getComponents($item)),
            $this->addSection('sections.top-sidebar', $this->getSidebarComponents($item)),
        ];


        $this->viewData['breadCrumbs'] = [
            route('category.view', $categorySlug) => $category->name,
            route('post.view', [$categorySlug, $slug]) => $item->title,
        ];

        return view('single', $this->viewData);
    }

    /**
     * @param $item
     * @return array
     */
    protected function getComponents(Post $item): array
    {
        $components = [
            $this->componentService
                ->setName('components.post-block')
                ->setData($item)->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                    'lock' => true
                ]),
            $this->componentService
                ->setName('components.owl-carousel-2')
                ->setData($this->getData($item->category->posts()->limit(20)->get()))
                ->setViewMore(true)
                ->setRoute(route('category.view', Category::ARTICLES_CATEGORY))
                ->setTitle(setting('site.articole-similare') ?? 'Articole similare')
                ->build([
                    'date' => true,
                    'views' => true,
                    'comments_count' => true,
                    'lock' => true,
                    'category' => true,
                    'link' => true,
                    'short' => 200,
                ]),
        ];
        if ($item->hasCommentsComponent()) {
            $components = [
                $this->componentService
                    ->setName('components.post-block')
                    ->setData($item)->build([
                        'date' => true,
                        'views' => true,
                        'link' => true,
                        'lock' => true
                    ]),
                $this->componentService
                    ->setName('components.comment')
                    ->setData($item)->build(),
                $this->componentService
                    ->setName('components.owl-carousel-2')
                    ->setData($this->getData($item->category->posts()->limit(20)->get()))
                    ->setViewMore(true)
                    ->setRoute(route('category.view', Category::ARTICLES_CATEGORY))
                    ->setTitle(setting('site.articole-similare') ?? 'Articole similare')
                    ->build([
                        'date' => true,
                        'views' => true,
                        'comments_count' => true,
                        'lock' => true,
                        'category' => true,
                        'link' => true,
                        'short' => 200,
                    ]),
            ];
        }


        if ($item->category->slug == Category::INSTRUIRE_CATEGORY) {
            $components = [
                $this->componentService
                    ->setName('components.post-block')
                    ->setData($item)->build([
                        'date' => true,
                        'views' => true,
                        'link' => true,
                        'lock' => true
                    ]),
                $this->componentService
                    ->setName('components.instruire-register')
                    ->setData($item)->build(),
            ];
        }

        return $components;
    }

    /**
     * @param $item
     * @return array
     */
    protected function getSidebarComponents($item): array
    {
        return [
            $this->componentService
                ->setName('components.sidebar.banner')
                ->setData(Banner::getBanners(Banner::POSITION_SIDEBAR))
                ->build(),
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($item->category->getPosts()->get())
                ->setTitle($item->category->name)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];
    }
}
