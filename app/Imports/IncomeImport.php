<?php

namespace App\Imports;

use App\Models\Income;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class IncomeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Income([
           'total_sales'=> $row[1],
           'total_transaction'=> $row[2],
           'total_discount'=> $row[3],
           'discount'=> $row[4],
           'tax'=> $row[5],
           'gross_profit'=> $row[6],
           'gross_profit_percentage'=> $row[7],
           'total_sales_returned'=> $row[8],
           'net_sales'=> $row[9],
           'average_net_sales'=> $row[10],
           'date'=> Carbon::parse($row[0])->format('Y-m-d'),


        ]);
    }
}
