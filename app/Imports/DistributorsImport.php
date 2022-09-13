<?php

namespace App\Imports;

use App\Models\Distributor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistributorsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Distributor([
            //
            'name'     => $row['name'],
            'email'    => $row['email'],
            'contact'    => $row['contact'],
            'location'    => $row['location'],
            'manufacturer_trading_type' => $row['manufacturer_trading_type'],
            
        ]);
    }
}
