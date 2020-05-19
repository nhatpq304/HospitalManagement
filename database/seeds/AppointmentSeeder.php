<?php

use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_count = \App\User::count();
        factory(\App\Models\Appointment::class, 50)->create([
            'patient_id' => function () use ($user_count) {
                return rand(1, $user_count);
            },
            'doctor_id' => function () use ($user_count) {
                return rand(1, $user_count);
            },
        ]);
    }
}
