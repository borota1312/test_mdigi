<?php

namespace Database\Seeders;

use App\Models\EntryHarian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['rekening_id' => 1, 'via_id' => 1, 'tanggal_setor' => '2025-01-02', 'jumlah_bayar' => '2000000'],
            ['rekening_id' => 3, 'via_id' => 2, 'tanggal_setor' => '2025-01-02', 'jumlah_bayar' => '1500000'],
            ['rekening_id' => 2, 'via_id' => 1, 'tanggal_setor' => '2025-01-09', 'jumlah_bayar' => '1750000'],
            ['rekening_id' => 1, 'via_id' => 2, 'tanggal_setor' => '2025-01-11', 'jumlah_bayar' => '2000000'],
            ['rekening_id' => 5, 'via_id' => 1, 'tanggal_setor' => '2025-01-12', 'jumlah_bayar' => '1000000'],

            ['rekening_id' => 2, 'via_id' => 1, 'tanggal_setor' => '2025-01-15', 'jumlah_bayar' => '1750000'],
            ['rekening_id' => 4, 'via_id' => 1, 'tanggal_setor' => '2025-01-15', 'jumlah_bayar' => '1250000'],
            ['rekening_id' => 2, 'via_id' => 1, 'tanggal_setor' => '2025-02-02', 'jumlah_bayar' => '1750000'],
            ['rekening_id' => 3, 'via_id' => 1, 'tanggal_setor' => '2025-02-03', 'jumlah_bayar' => '1500000'],
            ['rekening_id' => 3, 'via_id' => 1, 'tanggal_setor' => '2025-02-03', 'jumlah_bayar' => '1500000'],

            ['rekening_id' => 1, 'via_id' => 2, 'tanggal_setor' => '2025-02-05', 'jumlah_bayar' => '2000000'],
            ['rekening_id' => 2, 'via_id' => 2, 'tanggal_setor' => '2025-02-06', 'jumlah_bayar' => '1750000'],
            ['rekening_id' => 4, 'via_id' => 2, 'tanggal_setor' => '2025-02-10', 'jumlah_bayar' => '1250000'],
            ['rekening_id' => 5, 'via_id' => 2, 'tanggal_setor' => '2025-02-12', 'jumlah_bayar' => '1000000'],
            ['rekening_id' => 1, 'via_id' => 2, 'tanggal_setor' => '2025-02-12', 'jumlah_bayar' => '2000000'],
        ];
        foreach ($data as $v) {
            $form = array_merge($v, [
                'uuid' => Str::uuid()->toString(),
            ]);
            EntryHarian::create($form);
        }
    }
}
