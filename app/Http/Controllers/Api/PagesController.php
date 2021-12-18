<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Pages\AboutPageService;
use App\Services\Pages\AbstractPage;
use App\Services\Pages\ArticlesPageService;
use App\Services\Pages\ContactPageService;
use App\Services\Pages\HomePageService;
use App\Services\Pages\InformationPageService;
use App\Services\Pages\NewsPageService;
use App\Services\Pages\SeminarsPageService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getPage(string $page = 'home'): array
    {
        switch ($page) {
            case 'about':
                $service = AboutPageService::class;
                break;
            case 'news':
                $service = NewsPageService::class;
                break;
            case 'articles':
                $service = ArticlesPageService::class;
                break;
            case 'education':
                $service = SeminarsPageService::class;
                break;
            case 'contact':
                $service = ContactPageService::class;
                break;
            case 'information':
                $service = InformationPageService::class;
                break;
            case 'home':
            default:
                $service = HomePageService::class;
                break;
        }

        /** @var AbstractPage $pageService */
        $pageService = app()->make($service);
        return $pageService->setSearchFilters($this->filters)->getPage();
    }
}
