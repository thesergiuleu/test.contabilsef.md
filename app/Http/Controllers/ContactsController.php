<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\StoreContactsRequest;

class ContactsController extends SiteBaseController
{
    public function getPage()
    {
        $this->viewData['classes'] = 'lista-de-articole management pageContact';
        $this->viewData['map'] = true;
        $component = $this->componentService
            ->setName('components.contact')
            ->setData([])
            ->build();
        $this->viewData['sections'] = [
            $this->addSection('sections.central-no-div', [$component]),
        ];

        return view('single', $this->viewData);
    }

    public function store(StoreContactsRequest $request)
    {
        $data = $request->validated();
        Contact::query()->create($data);

        return response()->json([
            'status' => 'success',
            'message' => setting('raspunsuri.contact_store', 'Ve-ti fi contactat in curand.'),
            'redirect_url' => session()->get('_previous')['url']
        ]);
    }
}
