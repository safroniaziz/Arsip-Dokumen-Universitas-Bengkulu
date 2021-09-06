<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTableSeeder extends Seeder
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
            DB::table('units')->insert([
                'unit_id_induk'    =>  $faker->randomElement(['1','2','3']),
                'nm_unit'    =>  $faker->name(),
            ]);
        }
    }
}
