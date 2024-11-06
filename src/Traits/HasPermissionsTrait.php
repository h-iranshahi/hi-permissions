<?php

namespace Iransh\HiPermissions\Traits;

use Iransh\HiPermissions\Models\Permission;

trait HasPermissionsTrait
{

    public function givePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    public function withdrawPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->detach($permissions);

        return $this;
    }

    public function refreshPermissions(...$permissions)
    {

        $this->permissions()->detach();
        
        return $this->givePermissions($permissions);
    }

    /**
     * checkPermission
     * will be used for 'could' directive in view file
     * unknown permissions will be allowed for super admin
     *
     * @param  mixed $permissionName
     * @return void
     */
    public function checkPermission($permissionName)
    {
        $permission = Permission::where("name", $permissionName)->first();

        /*
        if (!$permission) Permission::create([
            'name' => $permissionName,
        ]);
        */

        if (!$permission) return false;
        
        return $this->hasAccess($permission);
    }


    /**
     * hasAccess
     * will be used for 'can' directive in view file
     * unknown permissions will be prevented for all
     *
     * @param  mixed $permission
     * @return void
     */
    public function hasAccess($permission)
    {
        if ($this->super_admin) return true;

        if ($this->hasAccessThroughRole($permission)) return true;

        if ($this->permissions()->where('name', $permission->name)->count()) return true;

        return false;
    }

    public function hasAccessThroughRole($permission)
    {
        $roles = $this->roles();

        $success = false;

        $permission->roles()->each(function ($role) use ($roles, &$success) {
            if (in_array($role->id, $roles->pluck('id')->toArray())) {
                $success = true;
                return false;
            }
        });

        return $success;
    }

    protected function getAllPermissions(array $permissions)
    {

        return Permission::whereIn('name', $permissions)->get();
    }
}
