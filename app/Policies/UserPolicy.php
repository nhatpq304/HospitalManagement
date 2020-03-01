<?php

namespace App\Policies;

use App\Http\Enum\permissionName;
use App\Http\Enum\permissionType;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->permissionType = permissionType::$USER;
    }

    public function index(User $user, User $model)
    {
        return $this->hasPermission($user, permissionName::$READ);
    }

    public function show(User $user, User $model)
    {
        return $this->hasPermission($user, permissionName::$READ);
    }

    public function store(User $user, User $model)
    {
        return $this->hasPermission($user, permissionName::$WRITE);
    }

    public function update(User $user, User $model)
    {
        return $this->hasPermission($user, permissionName::$UPDATE);
    }
}
