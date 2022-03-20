<?php

namespace App\Exports;

use App\Models\Kategori;
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

class KategoriExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping, WithColumnFormatting, WithColumnWidths
{
    use Exportable;

    public function headings(): array
    {
        return [
            ['Laporan Data Kategori'],
            [],
            [
                'Nomor',
                'Kategori',
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
        return Kategori::select(
            "kategori.id",
            "kategori.kategori",
            "kategori.created_at",
            "kategori.updated_at",
        )->get();
    }

    public function map($kategori): array
    {
        return [
            $kategori->id,
            $kategori->kategori,
            Date::dateTimeToExcel($kategori->created_at),
            Date::dateTimeToExcel($kategori->updated_at),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge Row satu
        $sheet->mergeCells('A1:D1');

        // Mengatur Alignment
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:D3')->getAlignment()->setHorizontal('center');
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
            'D' => 30,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
