<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToModel;

class MedicinesImport implements ToModel
{
    public function model(array $row)
    {
        return new Medicine([
            'name' => $row[1],
            'unit' => $row[2],
        ]);
    }
}
