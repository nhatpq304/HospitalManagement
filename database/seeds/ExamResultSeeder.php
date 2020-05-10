<?php

use Illuminate\Database\Seeder;

class ExamResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicines = \App\Models\Medicine::all();
        $user_count = \App\User::count();
        factory(\App\Models\ExamResult::class, 50)->create([
            'patient_id' => function () use ($user_count) {
                return rand(1, $user_count);
            },
            'doctor_id' => function () use ($user_count) {
                return rand(1, $user_count);
            },
        ])->each(function ($result) use($medicines) {
            $medArray = [];
            $medicines=  $medicines->random(rand(1,3));
            foreach ($medicines as $medicine) {
                $medArray[$medicine->id] = ['remark' => 'ghi chu', 'amount' => rand(1, 10)];
            }

            $result->medicines()->sync($medArray);
        });

    }
}
