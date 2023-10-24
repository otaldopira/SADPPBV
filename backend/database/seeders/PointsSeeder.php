<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('points')->insert([
            'nome' => 'Portaria',
        ]);
        DB::table('points')->insert([
            'nome' => 'Capela',
        ]);
        DB::table('points')->insert([
            'nome' => 'Auditório',
        ]);
        DB::table('points')->insert([
            'nome' => 'Laboratório 1',
        ]);
        DB::table('points')->insert([
            'nome' => 'Laboratório 2',
        ]);
        DB::table('points')->insert([
            'nome' => 'Laboratório 3',
        ]);
        DB::table('points')->insert([
            'nome' => 'Laboratório 3',
        ]);
        DB::table('points')->insert([
            'nome' => 'Banheiro',
        ]);


    }
}