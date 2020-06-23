<?php

use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupName = ['Admin', 'Doctors'];
        foreach ($groupName as $group) {
            factory(\App\Models\PermissionGroup::class)->make([
                'group_name' => $group
            ])->save();
        }

    }
}
