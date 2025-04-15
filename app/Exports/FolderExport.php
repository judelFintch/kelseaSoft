<?php

namespace App\Exports;

use App\Models\Folder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FolderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Folder::with(['transporter', 'company'])
            ->get()
            ->map(function ($folder) {
                return [
                    'Folder Number' => $folder->folder_number,
                    'Truck' => $folder->truck_number,
                    'Company' => $folder->company?->name,
                    'Transporter' => $folder->transporter?->name,
                    'Date' => $folder->arrival_border_date?->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Folder Number', 'Truck', 'Company', 'Transporter', 'Date'];
    }
}
