<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Classes\Code;
use App\Http\Models\PermissionsRouter;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function index()
    {
        return Permission::paginate(10);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            Permission::create(['name' => $request->name, 'route' => json_encode($request->route)]);
            return $this->response(Code::SUCCESS, '创建成功');
        } catch (\Exception $exception) {
            throw  new AppException('创建失败');
        }
    }

    public function show($id)
    {
        //
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
        try {
            $permission = Permission::findById($id);
            $status = $permission->delete();
            if ($status) {
                return $this->response(Code::SUCCESS, '，删除成功');
            } else {
                throw new \Exception('权限组删除失败');
            }
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
    }
}
