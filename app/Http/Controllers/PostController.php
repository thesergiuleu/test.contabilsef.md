<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends SiteBaseController
{
    protected $relations = ['posts'];

    public function __construct(Post $model)
    {
        parent::__construct();
        $this->entity = 'post';
        $this->model  = $model->with($this->relations)->published();
    }
}
