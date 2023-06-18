<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromQuery 
{
    // /**
    // // * @return \Illuminate\Support\Collection
    // // */
    // // public function collection()
    // // {
    // //     //ini_set('max_execution_time', 600);
    // //     return User::all();
    // //     //return User::all()->take(10);
    // // }
    // // public function failed(Throwable $exception): void
    // // {
    // //     // handle failed export
    // //    // (new UsersExport)->queue('invoices.xlsx')->onQueue('exports');
    // // }
    // use Exportable;


    public function query()
    {
        //ini_set('max_execution_time', 600);
        //return (new UsersExport)->queue('invoices.xlsx')->onQueue('exports');
        //return DB::table('users')->orderBy('name');
    }
}
