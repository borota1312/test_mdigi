<?php

namespace Database\Seeders;

use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_rekening' => 41101.01, 'nama_rekening' => 'Pajak Hotel Bintang 1'],
            ['kode_rekening' => 41101.02, 'nama_rekening' => 'Pajak Hotel Bintang 2'],
            ['kode_rekening' => 41101.03, 'nama_rekening' => 'Pajak Hotel Bintang 3'],
            ['kode_rekening' => 41101.04, 'nama_rekening' => 'Pajak Hotel Bintang 4'],
            ['kode_rekening' => 41101.05, 'nama_rekening' => 'Pajak Hotel Bintang 5'],
        ];
        foreach ($data as $v) {
            $form = array_merge($v, [
                'uuid' => Str::uuid()->toString(),
            ]);
            Rekening::create($form);
        }
    }
}
