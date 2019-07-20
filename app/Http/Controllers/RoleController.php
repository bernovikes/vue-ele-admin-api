<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Classes\Code;
use App\Http\Resources\RoleResource;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index()
    {
        return Role::paginate(10);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            if ($request->id) {
                $role = Role::findById($request->id);
                $role->name = $request->name;
                $group = collect($request->group)->map(function ($item) {
                    return $item['id'];
                });
                $save = $role->save();
                $role->givePermissionTo($group);
                if ($save) {
                    return $this->response(Code::SUCCESS, '更新成功');
                }else{
                    return new \Exception('角色更新失败');
                }
            } else {
                $role = Role::create(['name' => $request->name]);
                $role->givePermissionTo($request->group);
                if ($role->id) {
                    return $this->response(Code::SUCCESS, '创建成功');
                } else {
                    return new \Exception('角色创建失败');
                }
            }
        } catch (\Exception $exception) {
            return new AppException($exception->getMessage());
        }
    }


    public function show($id)
    {
        $role = Role::findById($id);
        return new RoleResource($role);
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            $role = Role::findById($id);
            $status = $role->delete();
            if ($status) {
                return $this->response(Code::SUCCESS, '，删除成功');
            } else {
                throw new \Exception('角色删除失败');
            }
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
    }
}
