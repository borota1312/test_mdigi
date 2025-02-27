<?php

namespace Database\Seeders;

use App\Models\MasterTarget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['rekening_id' => 2, 'target' => 70750000, 'berlaku_start' => '2024-01-01', 'berlaku_end' => '2024-12-31'],
            ['rekening_id' => 1, 'target' => 70500000, 'berlaku_start' => '2024-01-01', 'berlaku_end' => '2024-12-31'],
            ['rekening_id' => 5, 'target' => 50000000, 'berlaku_start' => '2025-01-01', 'berlaku_end' => '2025-12-31'],
            ['rekening_id' => 4, 'target' => 50250000, 'berlaku_start' => '2025-01-01', 'berlaku_end' => '2025-12-31'],
            ['rekening_id' => 3, 'target' => 50500000, 'berlaku_start' => '2025-01-01', 'berlaku_end' => '2025-12-31'],
            ['rekening_id' => 2, 'target' => 50750000, 'berlaku_start' => '2025-01-01', 'berlaku_end' => '2025-12-31'],
            ['rekening_id' => 1, 'target' => 60500000, 'berlaku_start' => '2025-01-01', 'berlaku_end' => '2025-12-31'],
        ];
        foreach ($data as $v) {
            $form = array_merge($v, [
                'uuid' => Str::uuid()->toString(),
            ]);
            MasterTarget::create($form);
        }
    }
}
