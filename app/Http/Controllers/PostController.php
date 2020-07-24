<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends SiteBaseController
{
    public function view($slug)
    {
        $item = Post::whereSlug($slug)->firstOrFail();

        $sidebar = [
            $this->componentService
                ->setName('components.sidebar.banner')
                ->setData([1])
                ->build(),
            $this->componentService
                ->setName('components.sidebar.side-block')
                ->setData($item->category->posts)
                ->setTitle($item->category->name)
                ->build(),
            $this->componentService
                ->setName('components.calendar')
                ->build()
        ];

        $component = $this->componentService->setName('components.post-block')->setData($item)->build();
        $this->viewData['sections'] = [
            $this->addSection('sections.central', [$component]),
            $this->addSection('sections.top-sidebar', $sidebar),
        ];

        return view('single', $this->viewData);
    }
}
