<?php

namespace App\Exports;

use App\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;


class MercadoLibreExport implements FromQuery
{
    use Exportable;

    // public function __construct(int $year)
    // {
    //     $this->year = $year;
    // }

    public function query()
    {
        // return Invoice::query()->whereYear('created_at', $this->year);
        return DB::table('templates')
        ->select('template_id')
        // ->where('template_id','=',$template_id)
        ->first();
    }
}
