<?php

namespace App\Imports;

use App\Models\IMEIProduct;
use Maatwebsite\Excel\Concerns\ToModel;

class IMEIProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new IMEIProduct([
            //
        ]);
    }
}
