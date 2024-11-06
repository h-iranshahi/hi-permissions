<?php

namespace Iransh\HiPermissions\Traits;

trait HasRolesTrait {

    public function assignRoles(...$roles) {

        if($roles === null) 
        {
            return $this;
        }

        $this->roles()->saveMany($roles);

        return $this;
    }

    public function hasRole(...$roles ) {

        foreach ($roles as $role) 
        {
            if ($this->roles->contains('name', $role)) 
            {
                return true;
            }
        }
        
        return false;
    }

}
