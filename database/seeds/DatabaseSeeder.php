<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionGroupSeeder::class );
        $this->call(PermissionsSeeder::class );
        $this->call(UsersTableSeeder::class);
//        $this->call(MedicineSeeder::class);
//        $this->call(ExamResultSeeder::class);
//        $this->call(AppointmentSeeder::class);
    }
}
