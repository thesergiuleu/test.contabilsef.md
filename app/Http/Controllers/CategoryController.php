<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends SiteBaseController
{
    protected $relations = ['posts'];
    public function __construct(Category $model)
    {
        parent::__construct();
        $this->entity = 'category';
        $this->model  = $model->with($this->relations);
    }
}
