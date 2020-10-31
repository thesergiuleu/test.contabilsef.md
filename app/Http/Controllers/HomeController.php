<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Offer;
use App\Page;
use App\Pool;
use App\Services\ComponentService;
use App\Services\PostsServiceInterface;
use stdClass;

class HomeController extends SiteBaseController
{
    private $postService;

    public function __construct(PostsServiceInterface $postService, ComponentService $componentService)
    {
        parent::__construct($componentService);
        $this->postService = $postService;
    }

    public function index(PostsServiceInterface $postsService)
    {
        $this->viewData['breadCrumbs'] = false;

        $side = $this->getSideMenu();

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $this->getComponents()),
            $this->addSection('sections.top-sidebar', $this->getTopSidebarComponents($side)),
            $this->addSection('sections.contact', []),
            $this->addSection('sections.central', $this->getBottomComponents()),
            $this->addSection('sections.top-sidebar', $this->getBottomSidebarComponents())
        ];

        return view('index', $this->viewData);
    }

    /**
     * @return array
     */
    private function getSideMenu(): array
    {
        $pages = [
            'page' => [
                1 => Page::SUBSCRIBE,
                4 => Page::CONSULTANT_SNC,
            ],
            'category' => [
                2 => Category::SNC_2020_CATEGORY,
                3 => Category::INDICATORI_FISCALI_CATEGORY,
                5 => Category::SINTEZA_MONITORULUI_OFICIAL_CATEGORY,
            ],
        ];

        $side = [];

        foreach ($pages as $key => $page) {
            foreach ($page as $order => $slug) {
                $sidebar = new stdClass();
                $sidebar->title = 'Pagina nu este creata';
                $sidebar->url = route('page.view', $slug);
                $sidebar->background = 'assets/imgs/' . $order . '.png';

                if ($key === 'page') {
                    $item = Page::whereSlug($slug)->first();

                    if ($item) {
                        $sidebar->title = $item->title;
                        $sidebar->url = route('page.view', $slug);
                    }
                } else {
                    $item = Category::whereSlug($slug)->first();
                    if ($item) {
                        $sidebar->url = route('category.view', $slug);
                        $sidebar->title = $item->name;
                    }
                }
                $side[$order] = $sidebar;
            }
        }

        return $side;
    }

    /**
     * @return array
     */
    protected function getComponents(): array
    {
        $allNewsPosts = $this->postService->setLimit(16)->setCategory(Category::NEWS_CATEGORY)->getPosts();
        $contabilSefNewsPosts = $this->postService->setLimit(14)->setCategory(Category::CONTABIL_SEF_NEWS_CATEGORY)->getPosts();
        $generalNewsPosts = $this->postService->setLimit(14)->setCategory(Category::GENERAL_NEWS_CATEGORY)->getPosts();
        $articlesPosts = $this->postService->setLimit(12)->setCategory(Category::ARTICLES_CATEGORY)->getPosts();

        return [
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($allNewsPosts))
                ->setViewMore(false)
                ->build([
                    'date' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.banner')
                ->setData(Banner::getBanners(Banner::POSITION_MAIN_TOP))
                ->build(),
            $this->componentService
                ->setName('components.block')
                ->setData($contabilSefNewsPosts->slice(0, 2))
                ->setTitle(setting('site.contabilsef') ?? 'contabil șef')
                ->build([
                    'date' => true,
                    'link' => true,
                    'short' => 120
                ]),
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($contabilSefNewsPosts->slice(2, 12)))
                ->setViewMore(true)
                ->setRoute(route('category.view', Category::CONTABIL_SEF_NEWS_CATEGORY))
                ->build([
                    'date' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.banner')
                ->setData(Banner::getBanners(Banner::POSITION_MAIN_CENTER))
                ->build(),
            $this->componentService
                ->setName('components.block')
                ->setData($generalNewsPosts->slice(0, 2))
                ->setTitle(setting('site.noutati') ?? 'noutăți')
                ->build([
                    'date' => true,
                    'link' => true,
                    'comments_count' => true,
                    'short' => 120
                ]),
            $this->componentService
                ->setName('components.owl-carousel')
                ->setData($this->getData($generalNewsPosts->slice(2, 12)))
                ->setViewMore(true)
                ->setRoute(route('category.view', Category::GENERAL_NEWS_CATEGORY))
                ->build([
                    'date' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.owl-carousel-2')
                ->setData($this->getData($articlesPosts))
                ->setViewMore(true)
                ->setRoute(route('category.view', Category::ARTICLES_CATEGORY))
                ->setTitle(setting('site.articole') ?? 'Articole')
                ->build([
                    'date' => true,
                    'comments_count' => true,
                    'lock' => true,
                    'category' => true,
                    'link' => true,
                    'short' => 200,
                ]),
        ];
    }

    /**
     * @param array $side
     * @return array
     */
    protected function getTopSidebarComponents(array $side): array
    {
        $instuirePosts = $this->postService->setLimit(7)->setCategory(Category::INSTRUIRE_CATEGORY)->setSortColumn('event_date')->setSortOrder('asc')->getPosts();
        $this->postService->setSortOrder('desc')->setSortColumn('created_at');
        $topItems = $this->getTopItems($this->postService);
        $offers = Offer::active()->get();

        return [
            $this->componentService
                ->setName('components.sidebar.post-links')
                ->setData($side)
                ->setViewMore(false)
                ->build(),
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($instuirePosts)
                ->setTitle(setting('site.instruire') ?? 'instruire')
                ->build(),
            $this->componentService
                ->setName('components.sidebar.banner')
                ->setData(Banner::getBanners(Banner::POSITION_SIDEBAR))
                ->build(),
            $this->componentService
                ->setName('components.sidebar.top')
                ->setData($topItems)
                ->setTitle(setting('site.top') ?? 'top cele mai citite')
                ->build([
                    'date' => true,
                ]),
            $this->componentService
                ->setName('components.sidebar.offers')
                ->setData($offers)
                ->setTitle(setting('site.work_offers') ?? 'oferte de serviciu')
                ->setAddNew(true)
                ->setViewMore(true)
                ->build(),
        ];
    }

    /**
     * @return array
     */
    protected function getBottomComponents(): array
    {
        $legislationPosts = $this->postService->setLimit(6)->setCategory(Category::LEGISLATION_CATEGORY)->getPosts();

        return [
            $this->componentService
                ->setName('components.bottom-block')
                ->setData($legislationPosts)
                ->setTitle(setting('site.legislatia') ?? 'legislatia')
                ->build([
                    'date' => true,
                    'link' => true,
                ]),
            $this->componentService
                ->setName('components.pool-block')
                ->setTitle(setting('site.pool') ?? 'sondaj de opinie')
                ->setData(Pool::all())
                ->build([])
        ];
    }

    private function getBottomSidebarComponents()
    {
        return [
            $this->componentService
                ->setName('components.calendar')
                ->build(),
            $this->componentService
                ->setName('components.newsletter')
                ->setRoute(route('newsletter'))
                ->build()
        ];
    }
}
