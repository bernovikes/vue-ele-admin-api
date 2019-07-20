<?php

namespace App\Http\Controllers;

use App\Http\Classes\Code;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return User::paginate(10);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $params = [
                'username' => $request->username,
                'name' => $request->name,
                'password' => Hash::make($request->password)
            ];
            $user = User::firstOrCreate(['username' => $request->username], $params);
            $user->assignRole($request->role);
            if ($user->wasRecentlyCreated) {
                return $this->response(Code::ERROR, '用户已存在');
            } else {
                return $this->response(Code::SUCCESS, '创建成功');
            }
        } catch (\Exception $exception) {
            return $this->response(Code::ERROR, $exception->getMessage());
        }
    }


    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
