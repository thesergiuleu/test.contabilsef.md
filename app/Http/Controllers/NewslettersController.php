<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterStoreRequest;
use App\Newsletter;

class NewslettersController extends Controller
{
    public function submit(NewsletterStoreRequest $request)
    {
        $request->validated();

        if (!Newsletter::query()->where('email', $request->get('email'))->exists()) {
            Newsletter::create([
                'email' => $request->get('email'),
                'name' => $request->input('name', null),
            ]);
        } else {
            return response()->json([
                'message' => setting('raspunsuri.newsletter_exist', 'Dumneavoastra sunteti deja abonat'),
                'status' => 'success',
                'redirect_url' => session()->get('_previous')['url']
            ]);
        }

        return response()->json(['message' => setting('raspunsuri.newsletter_store', 'Va-ti abonat la newsletter cu success.'), 'status' => 'success', 'redirect_url' => session()->get('_previous')['url']]);
    }
}
