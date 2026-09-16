<?php

namespace modules\Permission\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Modules\Shared\Http\Controllers\Api\BaseResponderController;
use Spatie\Permission\Models\Role;

class RoleController extends BaseResponderController
{
    public function roles(){
        $roles = Role::all();
        return $this->sendResponse($roles,'Roles retrieved successfully.');
    }
    public function getRole(int $id){
        $role = Role::findOrFail($id);
        return $this->sendResponse($role,'Role retrieved successfully.');
    }
    public function store(Request $request){}
    public function update(Request $request, int $id){}
    public function delete(int $id){}

}
