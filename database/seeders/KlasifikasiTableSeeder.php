<?php

namespace Database\Seeders;

use App\Models\KlasifikasiBerkas;
use Illuminate\Database\Seeder;

class KlasifikasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $klasifikasi = [
            [
                'nm_klasifikasi' => "KP",
                'keterangan' => 'Keterangan',
            ],
            [
                'nm_klasifikasi' => 'HK',
                'keterangan' => 'Keterangan',
            ],
            [
                'nm_klasifikasi' => "KP",
                'keterangan' => 'Keterangan',
            ],
            
        ];

        KlasifikasiBerkas::insert($klasifikasi);
    }
}
