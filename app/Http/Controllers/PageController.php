<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends SiteBaseController
{
    public function __construct(Page $model)
    {
        parent::__construct();
        $this->entity = 'page';
        $this->model  = $model->with($this->relations)->active();
    }
}
