<?php

namespace App\Http\Controllers;

use App\Services\ComponentService;
use App\Services\PostsServiceInterface;

class SiteBaseController extends Controller
{
    /**
     * @var array|int[]
     */
    protected static  $status = [
        '_0' => 0,
        '_1' => 1,
    ];
    /**
     * @var array
     */
    protected  $viewData;
    /**
     * @var ComponentService
     */
    protected  $componentService;
    /**
     * @var array
     */
    protected  $filters = [];

    public function __construct(ComponentService $componentService)
    {
        $this->viewData['sections'] = [];
        $this->viewData['breadCrumbs'] = [];
        $this->componentService = $componentService;

        $this->setFilters();
    }

    /**
     * @return void
     */
    protected function setFilters(): void
    {
        if (!is_null(request()->input('year_get', null))) {
            $this->filters = [
                'year' => request()->input('year_get')
            ];
        }
        if (!is_null(request()->input('month_get', null))) {
            $this->filters = array_merge($this->filters, [
                'month' => request()->input('month_get')
            ]);
        }
        if (!is_null(request()->input('status_get', null))) {
            $this->filters = array_merge($this->filters, [
                'status' => request()->input('status_get')
            ]);
        }
    }

    public function returnCollection(string $view, $items = [])
    {
        if (request()->wantsJson()) {
            return response()->json($items);
        }

        return view($view, $items);
    }

    public function returnObject(string $view, $item = null)
    {
        if (request()->wantsJson()) {
            return response()->json($item);
        }

        return view($view, $item);
    }

    protected function getTopItems(PostsServiceInterface $postsService)
    {
        return [
            'top_7' => $postsService->setCategory(null)->setLimit(7)->setSortColumn('views')->getPosts(),
            'top_30' => $postsService->setCategory(null)->setLimit(30)->setSortColumn('views')->getPosts(),
        ];
    }
}
