<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meja; // <-- INI BARIS KUNCI YANG PERLU DITAMBAHKAN

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meja::create(['nomor_meja' => 1, 'kode_meja' => 'M01']);
        Meja::create(['nomor_meja' => 2, 'kode_meja' => 'M02']);
        Meja::create(['nomor_meja' => 3, 'kode_meja' => 'M03']);
        Meja::create(['nomor_meja' => 4, 'kode_meja' => 'M04']);
        Meja::create(['nomor_meja' => 5, 'kode_meja' => 'M05']);
    }
}