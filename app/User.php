<?php

namespace App;

use App\Models\PermissionGroup;
use App\Objects\PermissionObject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'address',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function getPermissionsList()
    {
        $permissionList = [];
        foreach ($this->permissionGroups as $group) {
            foreach ($group->permissions as $permission) {
                $permissionList[] = new PermissionObject($permission->permission_name, $permission->permission_type);
            }
        }

        return $permissionList;
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    public function permissionGroups(){
        return $this->belongsToMany(PermissionGroup::class, 'users_permission_groups', 'user_id', 'permission_group_id');
    }
}
