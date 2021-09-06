<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
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
            DB::table('users')->insert([
                'unit_id'    =>  Unit::all()->random()->id,
                'nm_user'    =>  $faker->name(),
                'password'    =>  bcrypt("password"),
                'email'     =>  $faker->email(),
                'level' =>  $faker->randomElement(['administrator','operator','guest']),
                'status'    =>  $faker->randomElement(['aktif','nonaktif']),
            ]);
        }
    }
}
