<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Page;
use App\Services\Pages\AboutPageService;
use App\Services\Pages\AbstractPage;
use App\Services\Pages\ArticlesPageService;
use App\Services\Pages\ContactPageService;
use App\Services\Pages\HomePageService;
use App\Services\Pages\NewsPageService;
use App\Services\Pages\SeminarsPageService;

class PageController extends SiteBaseController
{
    public function getSubscribePage()
    {
        $page = Page::whereSlug(Page::SUBSCRIBE)->firstOrFail();

        $this->setPageViewData($page->slug, $page);

        return view('single', $this->viewData);
    }

    /**
     * @param $slug
     * @param Page $page
     */
    private function setPageViewData($slug, Page $page): void
    {
        $this->viewData['breadCrumbs'] = [
            route('page.view', $slug) => $page->title
        ];

        $this->viewData['classes'] = 'lista-de-articole Un-articole DespreProiect';

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $this->getComponents($page)),
        ];

        if ($page->has_sidebar) {
            array_push($this->viewData['sections'], $this->addSection('sections.top-sidebar', $this->getSidebarComponents($page)));
        } else {
            $this->viewData['fullPage'] = 1;
        }
    }

    protected function getComponents(Page $item): array
    {
        $components = [
            $this->componentService
                ->setName('components.page-block')
                ->setTitle($item->title)
                ->setData($item)->build([])
        ];

        return $components;
    }

    /**
     * @param $item
     * @return array
     */
    protected function getSidebarComponents($item): array
    {
        $category = Category::whereSlug(Category::INSTRUIRE_CATEGORY)->first();
        return [
            $this->componentService
                ->setName('components.sidebar.banner')
                ->setData(Banner::getBanners(Banner::POSITION_SIDEBAR))
                ->build(),
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($category->posts)
                ->setTitle($category->name)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];
    }

    public function view($slug)
    {
        $page = Page::whereSlug($slug)->firstOrFail();

        $this->setPageViewData($slug, $page);

        return view('single', $this->viewData);
    }

    public function getPage(string $page = 'home'): array
    {
        switch ($page) {
            case 'about':
                $service = AboutPageService::class;
                break;
            case 'news':
                $service = NewsPageService::class;
                break;
            case 'articles':
                $service = ArticlesPageService::class;
                break;
            case 'education':
                $service = SeminarsPageService::class;
                break;
            case 'contact':
                $service = ContactPageService::class;
                break;
            case 'information':
                $service = InformationPageService::class;
                break;
            case 'home':
            default:
                $service = HomePageService::class;
                break;
        }

        /** @var AbstractPage $pageService */
        $pageService = app()->make($service);
        return $pageService->getPage();
    }
}
