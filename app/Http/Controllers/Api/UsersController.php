<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getUser()
    {
        return getAuthUser();
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $data = array_filter($data);

        $user = getAuthUser();

        if (isset($data['password']))
            $data['password'] = Hash::make($data['password']);

        $user->fill($data);
        $user->save();

        $this->responseOk($user);
    }
}
