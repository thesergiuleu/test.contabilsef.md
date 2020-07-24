<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\PostsServiceInterface;
use Illuminate\Http\Request;

class HomeController extends SiteBaseController
{
    public function index(PostsServiceInterface $postsService)
    {
        $this->viewData['breadCrumbs'] = false;

        $carousel = $postsService->setLimit(16)->getPosts();
        $items = $postsService->setLimit(2)->getPosts();
        $side = $this->getSideMenu();
        $topItems = $this->getTopItems($postsService);
        $offers = [];

        $components = [
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($carousel))
                ->setViewMore(false)
                ->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.banner')
                ->setData([1,2])
                ->build(),
            $this->componentService
                ->setName('components.block')
                ->setData($items)
                ->setTitle(setting('site.contabilsef') ?? 'contabil șef')
                ->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                    'short' => 120
                ]),
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($carousel))
                ->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                    'comments_count' => false,
                    'lock' => false,
                    'category' => false
                ]),
            $this->componentService
                ->setName('components.banner')
                ->setData([1,2])
                ->build(),
            $this->componentService
                ->setName('components.block')
                ->setData($items)
                ->setTitle(setting('site.noutati') ?? 'noutăți')
                ->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                    'comments_count' => true,
                    'short' => 120
                ]),
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($carousel))
                ->build([
                    'date' => true,
                    'views' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.owl-carousel-2')
                ->setData($this->getData($carousel))
                ->setTitle(setting('site.articole') ?? 'Articole')
                ->build([
                    'date' => true,
                    'views' => true,
                    'comments_count' => true,
                    'lock' => true,
                    'category' => true,
                    'link' => true,
                    'short' => 200
                ]),
        ];

        $topSidebarComponents = [
            $this->componentService
                ->setName('components.sidebar.post-links')
                ->setData($side)
                ->setViewMore(false)
                ->build(),
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($items)
                ->setTitle(setting('site.instruire') ?? 'instruire')
                ->build(),
            $this->componentService
                ->setName('components.sidebar.banner')
                ->setData([1])
                ->build(),
            $this->componentService
                ->setName('components.sidebar.top')
                ->setData($topItems)
                ->setTitle(setting('site.top') ?? 'top cele mai citite')
                ->build(),
            $this->componentService
                ->setName('components.sidebar.offers')
                ->setData($offers)
                ->setTitle(setting('site.offers') ?? 'oferte de serviciu')
                ->setAddNew(true)
                ->build(),
        ];

        $bottomComponents = [
            $this->componentService
                ->setName('components.bottom-block')
                ->setData($items)
                ->setTitle(setting('site.legislatia') ?? 'legislatia')
                ->build([
                    'date' => true,
                    'views' => true,
                ]),

        ];

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $components),
            $this->addSection('sections.top-sidebar', $topSidebarComponents),
            $this->addSection('sections.contact', []),
            $this->addSection('sections.central', $bottomComponents),
        ];

        return view('index', $this->viewData);
    }

    /**
     * @return array
     */
    private function getSideMenu(): array
    {
        $side = [];
        for ($i = 0; $i < 4; $i++) {
            $sidebar = new \stdClass();
            $sidebar->post_url = '#';
            $sidebar->title = 'Actual Title';
            $sidebar->category = "#";
            $key = $i + 1;
            $sidebar->background = 'assets/imgs/' . $key . '.png';

            $side[$i] = $sidebar;
        }
        return $side;
    }

    public function getTopItems(PostsServiceInterface $postsService)
    {
        return [
            'top_7' => $postsService->setLimit(7)->getTopSeven(),
            'top_30' => $postsService->setLimit(30)->getTopThirty(),
        ];
    }
}
