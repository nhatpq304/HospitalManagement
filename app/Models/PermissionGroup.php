<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'groups_permissions', 'group_id', 'permission_id');
    }
}
