<?php

namespace App\Http\Controllers\Api;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactsRequest;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function contactUs(StoreContactsRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        Contact::query()->create($data);

        return responseSuccess([], 'Ve-ti fi contactat in curand.');
    }
}
