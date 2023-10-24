<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SegmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('segments')->insert([
            'ponto_inicial' => 1, 
            'ponto_final' => 2, 
            'direcao'=> 'Norte',
            'distancia' => 10.5,
            'status' => 1,
        ]);
        DB::table('segments')->insert([
            'ponto_inicial' => 2, 
            'ponto_final' => 3, 
            'direcao'=> 'Oeste',
            'distancia' => 10.5,
            'status' => 1,
        ]);
        DB::table('segments')->insert([
            'ponto_inicial' => 2, 
            'ponto_final' => 4, 
            'direcao'=> 'Leste',
            'distancia' => 10.5,
            'status' => 1,
        ]);
        DB::table('segments')->insert([
            'ponto_inicial' => 4, 
            'ponto_final' => 5, 
            'direcao'=> 'Oeste',
            'distancia' => 10.5,
            'status' => 1,
        ]);
        DB::table('segments')->insert([
            'ponto_inicial' => 5, 
            'ponto_final' => 6, 
            'direcao'=> 'Norte',
            'distancia' => 10.5,
            'status' => 1,
        ]);
        DB::table('segments')->insert([
            'ponto_inicial' => 6, 
            'ponto_final' => 7, 
            'direcao'=> 'Norte',
            'distancia' => 10.5,
            'status' => 1,
        ]);
    }
}