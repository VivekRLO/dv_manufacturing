<?php

namespace App\Imports;

use App\Models\Distributor;
use App\Models\User;
use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OutletsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $distributor=Distributor::where('town_id',$row['town_id'])->first();
        $sales_officer=User::where('id',$row['dse_id'])->first();
        $newoutlet=new Outlet([
            //
            'name' => $row['outlet_name'],
            'town_id'    => $row['town_id'],
            'route_id' => $row['route_name_id'],
            'distributor_id' => $distributor->id,
            // 'distributor_id' =>$distributor->id,
            'channel_id' => $row['channel_id'],
            'category_id' => $row['category_id'],
            'sales_officer_id'=>$row['dse_id'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
        ]);
          
          $distributor->distributor_salesOfficer()->where('user_id', $sales_officer->id)->exists() ? : $distributor->distributor_salesOfficer()->attach($sales_officer);

        return $newoutlet;
    }
}
