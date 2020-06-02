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
    {
        $medicines = ['Paracetamol 500', 'Alphachoay', 'Panadol', 'Berberin', 'Cồn 90', 'Histamin', 'Oresol'];
        foreach ($medicines as $medicine) {
            factory(\App\Models\Medicine::class)->make([
                'name' => $medicine,
                'unit' => 'Hộp'
            ])->save();
        }
    }
}
