<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class SiteBaseController extends Controller
{

    protected $entity;
    protected $model;
    protected $relations = [];
    protected $limit = '20';
    protected $sortColumn = 'id';
    protected $sortOrder = 'desc';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->sortColumn = request()->get('sortColumn') ?? $this->sortColumn;
        $this->sortOrder = request()->get('sortOrder') ?? $this->sortOrder;
    }
    public function index()
    {
        $this->beforeIndexInitHook();
        $items = $this->model->orderBy($this->sortColumn, $this->sortOrder)->paginate($this->limit);
        return $this->returnCollection($this->entity . '.index', $items);
    }

    public function view($id)
    {
        $this->beforeViewInitHook();
        $item = $this->model->findOrFail($id);
        $this->afterViewInitHook($item);
        return $this->returnObject($this->entity . '.view', $item);
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

    protected function beforeIndexInitHook(): void
    {
    }

    protected function beforeViewInitHook(): void
    {
    }

    protected function afterViewInitHook(&$item): void
    {
    }
}
