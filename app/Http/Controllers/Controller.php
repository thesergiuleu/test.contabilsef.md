<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $filters = [];

    public function __construct()
    {
        $this->setFilters();
    }

    /**
     * @return void
     */
    protected function setFilters(): void
    {
        if (!is_null(request()->input('year', null))) {
            $this->filters = [
                'year' => request()->input('year')
            ];
        }
        if (!is_null(request()->input('month', null))) {
            $this->filters = array_merge($this->filters, [
                'month' => request()->input('month')
            ]);
        }
        if (!is_null(request()->input('type', null))) {
            $this->filters = array_merge($this->filters, [
                'status' => request()->input('type')
            ]);
        }
    }

    /**
     * @param string $name
     * @param $data
     * @param string|null $title
     * @param bool $viewMore
     * @param bool $addNew
     * @param array $options
     * @return array
     */
    protected function addComponent(string $name, $data, string $title = null, $viewMore = true, $addNew = false, $options = []): array
    {
        return [
            'title' => $title,
            'name' => $name,
            'data' => $data,
            'view_more' => $viewMore,
            'add_new' => $addNew,
            'options' => $options
        ];
    }

    /**
     * @param string $name
     * @param array $components
     * @return array
     */
    protected function addSection(string $name, array $components): array
    {
        return [
            'name' => $name,
            'components' => $components,
        ];
    }

    /**
     * @param Collection $collection
     * @param int $limit
     * @return Collection
     */
    protected function getData(Collection $collection, $limit = 4): Collection
    {
        return $collection->chunk($limit);
    }

    public function responseOk($data): JsonResponse
    {
        return response()->json($data);
    }
}
