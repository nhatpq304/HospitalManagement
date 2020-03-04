<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 3/1/2020
 * Time: 9:38 PM
 */

namespace App\Policies;



use App\Http\Enum\permissionName;
use App\User;

class BasePolicy
{
    public $permissionType;

    public function hasPermission(User $user, String $perName) {
        $permissions = $user->getPermissionsList();

        foreach ($permissions as $permission) {
            if (($permission->name == $perName || $permission->name == permissionName::$ADMIN ) && $permission->type == $this->permissionType) {
                return true;
            }
        }
        return false;
    }
}