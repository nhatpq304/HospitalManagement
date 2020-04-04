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
        \App\User::find(1)->media()->make([
            'media_link' => 'link',
            'media_type' => 'IMAGE',
            'is_active' => true
        ])->save();
        factory(\App\User::class, 50)->create()->each(function ($user){
            $user->media()->make([
                'media_link' => 'https://happeacehospital.s3-ap-southeast-1.amazonaws.com/images/Lk3K28NbZnBGvVEWEPRpmGfyPsIwU9YeLE04OFd6.png',
                'media_type' => 'IMAGE',
                'is_active' => true
            ])->save();
        });
    }
}
