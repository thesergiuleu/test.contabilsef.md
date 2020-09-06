<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePoolRequest;
use App\Pool;

class PoolsController extends Controller
{
    public function vote(StorePoolRequest $request, Pool $pool)
    {
        $data = $request->validated();

        $pool->answers()->create($data);

        return redirect()->back();
        return response()->json([
            'message' => '',
            'status' => 'success',
            'redirect_url' => route('home')
        ]);
    }
}
