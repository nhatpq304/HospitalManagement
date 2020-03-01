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
        $groupName = ['ADMIN','READ', 'UPDATE', 'WRITE'];
        foreach ($groupName as $group) {
            factory(\App\Models\Permission::class)->make([
                'permission_name' => $group
            ])->save();
        }
    }
}
