<?php

namespace modules\Permission\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use modules\Permission\Http\Resources\RoleResource;
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
        return $this->sendResponse(new RoleResource($role),'Role retrieved successfully.');
    }
    public function store(Request $request){
        $role = Role::create(['name' => $request->name,'guard_name' => 'api']);
        $role->syncPermissions($request->permissions);
        return $this->sendResponse(new RoleResource($role),'Role created successfully.');
    }
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);

        // Update the role name
        $role->update([
            'name' => $request->name,
            'guard_name' => 'api',
        ]);

        // Sync permissions (accepts array of permission IDs)
        $role->syncPermissions($request->permissions);

        return $this->sendResponse(new RoleResource($role), 'Role updated successfully.');
    }

    public function userWithPermission(Request $request){
        $user = auth()->user();
    }
    public function delete(int $id){
        $role = Role::findOrFail($id);
        return $this->sendResponse($role->delete(),'Role deleted successfully.');
    }

}
