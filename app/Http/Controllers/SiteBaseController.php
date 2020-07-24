<?php

namespace App\Http\Controllers;

use App\Page;
use App\Services\ComponentService;
use Illuminate\Http\Request;

class SiteBaseController extends Controller
{
    /**
     * @var array
     */
    protected array $viewData;
    /**
     * @var ComponentService
     */
    protected ComponentService $componentService;

    /**
     * @var array
     */
    protected array $filters = [];
    /**
     * @var array|int[]
     */
    protected static array $status = [
        '_0' => 0,
        '_1' => 1,
    ];


    public function __construct(ComponentService $componentService)
    {
        $this->viewData['sections'] = [];
        $this->viewData['breadCrumbs'] = true;
        $this->componentService = $componentService;

        $this->setFilters();
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
}
