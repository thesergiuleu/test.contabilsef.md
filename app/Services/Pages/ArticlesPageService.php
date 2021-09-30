<?php

namespace App\Services\Pages;

use App\Category;
use App\Http\Resources\GeneralCollection;
use App\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlesPageService extends AbstractPage
{

    public function getPage(): array
    {
        return $this->getGeneralListLayout(Category::ARTICOLE);
    }
}
