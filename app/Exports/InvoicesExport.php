<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements  FromQuery , WithHeadings, WithCustomChunkSize
{
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'name',
            'email',
        ];
    }

    public function query()
    {
        return User::query();
    }

    public function chunkSize(): int
    {
        return 10000;
    }
}