<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferStoreRequest;
use App\Offer;
use App\Services\PostsServiceInterface;
use function request;

class OfferController extends SiteBaseController
{
    public function index()
    {
        $offers = request()->input('vacancy', null) ? Offer::active()->whereVacancy(request()->get('vacancy'))->paginate(5) : Offer::active()->paginate(5);

        $this->viewData['breadCrumbs'] = [
            route('offer.index') => "Oferte",
        ];

        $component = $this->componentService
            ->setName('offers.components.list')
            ->setTitle(setting('site.offers') ?? 'Oferte')
            ->setData($offers)
            ->setRoute(route('offer.index'))
            ->build();

        $this->viewData['sections'] = [
            $this->addSection('offers.index', [$component]),
        ];

        return view('offers', $this->viewData);
    }

    public function view(PostsServiceInterface $postsService, Offer $offer)
    {
        $this->viewData['breadCrumbs'] = [
            route('offer.index') => "Oferte",
            route('offer.view', $offer->id) => $offer->title
        ];

        $component = $this->componentService
            ->setName('offers.components.single')
            ->setTitle($offer->vacancy)
            ->setData($offer)
            ->build();

        $sidebarComponents = [
            $this->componentService
                ->setName('components.sidebar.top')
                ->setData($this->getTopItems($postsService))
                ->setTitle(setting('site.top') ?? 'top cele mai citite')
                ->build(),
            $this->componentService
                ->setName('components.sidebar.offers')
                ->setData(Offer::active()->get())
                ->setTitle(setting('site.work_offers') ?? 'oferte de serviciu')
                ->setAddNew(true)
                ->build(),
        ];

        $this->viewData['sections'] = [
            $this->addSection('sections.central', [$component]),
            $this->addSection('sections.top-sidebar', $sidebarComponents),
        ];

        return view('single', $this->viewData);
    }

    public function create()
    {
        $this->viewData['classes'] = 'lista-de-articole adauga-un-job';
        $this->viewData['breadCrumbs'] = [
            route('offer.index') => "Oferte",
            route('offer.create') => "Adăugare ofertă"
        ];

        $component = $this->componentService
            ->setName('offers.components.create')
            ->setData([])
            ->setTitle(__('Adăugare ofertă'))
            ->build();

        $this->viewData['sections'] = [
            $this->addSection('offers.index', [$component])
        ];

        return view('offers', $this->viewData);
    }

    public function store(OfferStoreRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('logo');

        if ($file) {
            $storedFile = $file->storePublicly('public/offers/logos');
            $data['logo'] = $storedFile;
        }

        Offer::query()->create($data);

        return response()->json([
            'message' => setting('raspunsuri.offer_store', 'Jobul a fost salvat si va fi publicat indata ce e revizuit de un admin.'),
            'status' => 'success',
            'redirect_url' => route('offer.index')
        ]);
    }
}
