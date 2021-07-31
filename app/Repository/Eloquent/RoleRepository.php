<?php

namespace App\Repository\Eloquent;

use App\Models\Role;
use App\Repository\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function getRoleNameAndId()
    {
        return Role::pluck('rolename', 'id');
    }

}
