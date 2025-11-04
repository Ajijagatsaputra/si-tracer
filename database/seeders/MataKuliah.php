<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataKuliah extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataKuliahs = [
            'Machine Learning',
            'Data Mining',
            'Statistik',
            'Matematika Diskrit',
            'Big Data',
            'Data Warehouse',
            'Pemrograman Komputer 1',
            'Pemrograman Komputer 2',
            'Pemrograman Web 1',
            'Pemrograman Web 2',
            'Framework Programming',
            'Web Service',
            'Basis Data 1',
            'Basis Data 2',
            'Sistem Operasi',
            'Jaringan Komputer 1',
            'Jaringan Komputer 2',
            'Keamanan Data & Jaringan',
            'Analisis & Desain PL',
            'Manajemen Proyek TI',
            'Pengantar RPL',
            'Desain Grafis',
            'Interaksi Manusia & Komputer',
        ];

        foreach ($mataKuliahs as $mataKuliah) {
            \DB::table('mata_kuliah')->insert([
                'mataKuliah' => $mataKuliah,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
