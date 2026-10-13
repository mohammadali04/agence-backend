<?php

namespace modules\Permission\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;
use Spatie\Permission\Models\Permission;

class PermissionController extends BaseResponderController
{
    public function permissions(){
        $permissions = Permission::all();
        return $this->sendResponse($permissions, 'Permissions retrieved successfully.');
    }
    public function getPermission(int $id)
    {
        $permission = Permission::findOrFail($id);
        return $this->sendResponse($permission, 'Permission retrieved successfully.');
    }
    public function store(Request $request) {
        $permission = Permission::create(['name' => $request->name,'guard_name' => 'api']);
        return $this->sendResponse($permission, 'Permission created successfully.');
    }
    public function update(Request $request, int $id){}
    public function delete(int $id){}

}
