<?php

namespace App\Services\Pages;

use App\Category;

class NewsPageService extends AbstractPage
{

    public function getPage(): array
    {
        return $this->getGeneralListLayout(Category::NEWS_CATEGORY);
    }
}
