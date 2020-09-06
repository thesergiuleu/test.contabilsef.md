<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstruireRegisterRequest;
use App\Post;

class InstruireController extends Controller
{
    public function register(StoreInstruireRegisterRequest $request, Post $post)
    {
        $data = $request->validated();

        $post->postRegisters()->create($data);

        //todo send email

        return response()->json([
            'message' => setting('raspunsuri.instruire_register', 'Va-ti inregistrat cu success. Verificati email-ul pentru mai multe detalii.'),
            'status' => 'success',
            'redirect_url' => session()->get('_previous')['url']
        ]);
    }
}
