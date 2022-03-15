<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class KategoriExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kategori::all();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Kategori',
            'Tanggal Dibuat',
            'Terakhir Diperbarui',
        ];
    }
}
