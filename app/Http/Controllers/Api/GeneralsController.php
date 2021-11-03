<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralsController extends Controller
{
    public function footerMenu(): JsonResponse
    {
        return responseSuccess([
            'about' => menu('footer-despre-noi', '_json')->values(),
            'news' => menu('footer-noutati', '_json')->values(),
            'study' => menu('footer-studiem', '_json')->values(),
            'articles' => menu('footer-articole', '_json')->values(),
            'legislation' => menu('footer-legislatia', '_json')->values(),
            'utils' => menu('footer-informatii-utile', '_json')->values(),
        ]);
    }
}
