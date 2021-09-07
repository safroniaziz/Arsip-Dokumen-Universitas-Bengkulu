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
        $faker = \Faker\Factory::create();
        $klasifikasi = [
            [
                'nm_klasifikasi' => "KP",
                'keterangan' => 'Keterangan',
                'user_id'   =>KlasifikasiBerkas::all()->random()->id,
                'status'    =>  $faker->randomElement(['aktif','nonaktif']),
            ],
            [
                'nm_klasifikasi' => 'HK',
                'keterangan' => 'Keterangan',
                'user_id'   =>  KlasifikasiBerkas::all()->random()->id,
                'status'    =>  $faker->randomElement(['aktif','nonaktif']),
            ],
            [
                'nm_klasifikasi' => "KP",
                'keterangan' => 'Keterangan',
                'user_id'   =>  KlasifikasiBerkas::all()->random()->id,
                'status'    =>  $faker->randomElement(['aktif','nonaktif']),
            ],
            
        ];

        KlasifikasiBerkas::insert($klasifikasi);
    }
}
