<?php

namespace App\Exports;

use App\Models\Division;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Support\Types\LanguageType;

class DivisionExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Created_by',
            'Created_at',
            'Updated_at' 
        ];
    } 
    public function map($data): array
    {
         return[
             $data->id,
             $data->name,
             $data->CreatedBy ? $data->CreatedBy->full_name : '',
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return Division::with(['CreatedBy'])->get();
    }
}
