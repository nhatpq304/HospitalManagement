<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->make([
            'name' => Str::random(10),
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
        ])->save();
        $group = \App\Models\PermissionGroup::find(1);

        \App\User::find(1)->permissionGroups()->attach($group);
        $group->permissions()->attach(\App\Models\Permission::find(1));

        factory(\App\User::class,10)->create();
    }
}
