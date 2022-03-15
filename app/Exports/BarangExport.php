<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class BarangExport implements FromCollection, WithHeadings
{
    use Exportable;

    // public function __construct($q)
    // {
    //     $this->cari = $q;
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Barang::all();
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'Kategori',
            'Nama Barang',
            'Harga',
            'Tanggal Dibuat',
            'Terakhir Diperbarui',
        ];
    }

    // public function query()
    // {
    //     return Invoice::query()->whereYear('created_at', $this->year);
    // }
}
