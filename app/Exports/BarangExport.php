<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BarangExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping, WithColumnFormatting, WithColumnWidths
{
    use Exportable;

    // public function __construct($q)
    // {
    //     $this->cari = $q;
    // }

    public function headings(): array
    {
        return [
            ['Laporan Data Barang'],
            [],
            [
                'Nomor',
                'Kategori',
                'Nama Barang',
                'Harga',
                'Stok',
                'Tanggal Dibuat',
                'Terakhir Diperbarui',
            ]
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return barang::select(
            "barang.id",
            "kategori.kategori as kategori",
            "barang.nama",
            "barang.harga",
            "barang.stock",
            "barang.created_at",
            "barang.updated_at",
        )->join("kategori", "kategori.id", "=", "barang.idkategori")->get();
    }

    public function map($barang): array
    {
        // dd($barang->count());

        return [
            $barang->id,
            $barang->kategori,
            $barang->nama,
            $barang->harga,
            $barang->stock,
            Date::dateTimeToExcel($barang->created_at),
            Date::dateTimeToExcel($barang->updated_at),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge Row satu
        $sheet->mergeCells('A1:G1');

        // Mengatur Alignment
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:G3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');

        // Font
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->getStyle(1)->getFont()->setSize(20);

        // Border
        // $sheet->getStyle("A3:F6")->getBorders()->setLeft(Border::BORDER_THICK);
        // $sheet->getStyle("A3:F6")->getBorders()->setRight(Border::BORDER_THICK);
        // $sheet->getStyle("A3:F6")->getBorders()->setTop(Border::BORDER_THICK);
        // $sheet->getStyle("A3:F6")->getBorders()->setBottom(Border::BORDER_THICK);
        // 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //     'color' => ['argb' => 'FFFF0000'],
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 30,
            'D' => 15,
            'E' => 15,
            'F' => 30,
            'G' => 30,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            // 'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
