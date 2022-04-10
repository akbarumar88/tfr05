<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data seeder untuk data pelanggan.
        $pelanggan = [
            [
                'nama' => 'Raviy Bayu Seiaji',
                'alamat' => 'Sedati, Sidoarjo',
                'notelp' => '083117208771',
            ],
            [
                'nama' => 'Aldo Reghan',
                'alamat' => 'Sidoarjo, Sidoarjo',
                'notelp' => '085104021573',
            ],
            [
                'nama' => 'Bagaskara Antaris',
                'alamat' => 'Perum. Bhayangkaran Masangan Kulon Sukodono Blok G No. 12b',
                'notelp' => '083171872330',
            ],
            [
                'nama' => 'Aldhi Nur',
                'alamat' => 'SiwalanPandji, Buduran, Sidoarjo',
                'notelp' => '081171872330',
            ],
            [
                'nama' => 'Wanda Berlian',
                'alamat' => 'Adi Buana, Sidoarjo',
                'notelp' => '081176870330',
            ],
            [
                'nama' => 'Indra Arsy K',
                'alamat' => 'Sukodono, Sukodono',
                'notelp' => '085171871330',
            ],
            [
                'nama' => 'Indah P',
                'alamat' => 'Masangan Wetan, Sukodono, Sidoarjo',
                'notelp' => '087171872331',
            ],
        ];

        foreach ($pelanggan as $i => $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}
