<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'name' => 'ТП',
          ]);

        DB::table('departments')->insert([
        'name' => 'НПО',
        ]);

        DB::table('departments')->insert([
            'name' => 'НГПиЭО',
          ]);

        DB::table('departments')->insert([
        'name' => 'ПГМТР',
        ]);
    }
}
