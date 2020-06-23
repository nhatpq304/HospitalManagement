<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\Models\Permission::class)->make([
            'permission_name' => 'ADMIN',
            'permission_type' => 'ADMIN'
        ])->save();

        $groupName = ['READ', 'UPDATE', 'WRITE'];
        $types = ['USER','RESULT','MEDICINE', 'APPOINTMENT'];
        foreach ($types as $type) {
            foreach ($groupName as $group) {
                factory(\App\Models\Permission::class)->make([
                    'permission_name' => $group,
                    'permission_type' => $type
                ])->save();
            }
        }
        \App\Models\PermissionGroup::find(2)->permissions()->attach([2,5,6,7,8,11,12,13]);

    }
}
