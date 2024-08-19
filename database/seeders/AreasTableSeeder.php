<?php

// database/seeders/AreasTableSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    public function run()
    {
        $areas = [
            'District',
            'Taluka',
            'Urban-Rural',
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert(['name' => $area]);
        }
    }
}

