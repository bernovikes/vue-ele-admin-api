<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(UserRequest $request, User $user)
    {
        try {
            $find = $user->where(['username' => $request->username])->firstOrFail();
            if (!Hash::check($request->password, $find->password)) {
                throw  new \Exception('用户名或密码错误');
            }
            return new UserResource($find);
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
    }
}
