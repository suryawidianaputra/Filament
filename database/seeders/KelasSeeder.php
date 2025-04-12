<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Kelas::insert([
            ['nama_kelas' => 'X'],
            ['nama_kelas' => 'X'],
            ['nama_kelas' => 'XI'],
        ]);
    }
}
