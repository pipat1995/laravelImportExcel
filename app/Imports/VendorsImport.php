<?php

namespace App\Imports;

use App\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorsImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Vendor([
            'PLANT_CODE' => $row['Plant'],
            'MAT_CODE' => $row['Mat_Code'],
            'VENDOR_ID' => $row['Vendor ID'],
            'VENDOR_NAME' => $row['Vendor Name'],
        ]);
    }
}
