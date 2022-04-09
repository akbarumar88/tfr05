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
                'nama' => 'Akbar Umar Alfaroq',
                'alamat' => 'Perum. Bukit Permata Sukodono Blok J 12A',
                'notelp' => '083117208776',
            ],
            [
                'nama' => 'Firmansyah Firdaus Anhar',
                'alamat' => 'Perum. Citra Fajar Golf Buduran Blok I 23b',
                'notelp' => '085606021573',
            ],
            [
                'nama' => 'Muhammad Yafi Firdaus',
                'alamat' => 'Perum. Kahuripan Nirwana Blok AG-23',
                'notelp' => '083178872330',
            ],
        ];

        foreach ($pelanggan as $i => $pelanggan) {
            Pelanggan::create($pelanggan);
        }
    }
}
