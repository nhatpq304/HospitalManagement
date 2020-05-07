<?php

use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   $medicines= ['Paracetamol 500', 'Alphachoay', 'Panadol'];
        foreach ($medicines as $medicine) {
            factory(\App\Models\Medicine::class)->make([
                'brand_name' => $medicine,
                'origin_name' => $medicine
            ])->save();
        }
    }
}
