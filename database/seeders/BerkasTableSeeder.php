<?php

namespace Database\Seeders;

use App\Models\KlasifikasiBerkas;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BerkasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,30) as $index) {
            DB::table('berkas')->insert([
                'klasifikasi_id'    =>  KlasifikasiBerkas::all()->random()->id,
                'operator_id'    =>  $faker->randomElement(['4','24','29','30']),
                'unit_id'    =>  $faker->randomElement(['1','2','3']),
                'jenis_berkas' => $faker->text(),
                'file'    =>  $faker->text(),
                'nomor_berkas'  =>  $faker->randomNumber(),
                'uraian_informasi' => $faker->text(),
            ]);
        }
    }
}
