<?php

namespace App\Http\Controllers;

use App\Glosary;

class GlosaryController extends SiteBaseController
{
    public function index()
    {
        $this->viewData['breadCrumbs'] = [
            route('glossary.index') => 'Dicţionar contabil'
        ];
        $this->viewData['classes'] = 'lista-de-articole management DespreProiect Sinteza SNC SNCinterior Dictionar';

        $items = Glosary::query()
            ->when(request()->has('start_with'), function ($query) {
                $query->where('keyword', 'like', request()->get('start_with') . '%');
            })
            ->when(request()->has('search'), function ($query) {
                $query->where('keyword', 'like', '%' . request()->get('search') . '%')->orWhere('description', 'like', '%' . request()->get('search') . '%');
            })->paginate(20);

        $this->viewData['sections'] = [
            $this->addSection('sections.central', $this->getComponents($items)),
            $this->addSection('sections.top-sidebar', $this->getSidebarComponents()),
        ];
        return view('single', $this->viewData);
    }

    private function getComponents($items)
    {
        return [
            $this->componentService->setTitle('Dicţionar contabil')
                ->setName('components.glossary-page')
                ->setData($items)
                ->build([])
        ];
    }

    private function getSidebarComponents()
    {
        $str = 'A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z';

        $letters = explode(', ', $str);

        return [
            $this->componentService
                ->setName('components.sidebar.glossary-search')
                ->setData($letters)
                ->build([])
        ];
    }
}
