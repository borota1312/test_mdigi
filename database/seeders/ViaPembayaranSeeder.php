<?php

namespace Database\Seeders;

use App\Models\ViaPembayaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ViaPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Bendahara'],
            ['nama' => 'Bank'],
        ];
        foreach ($data as $v) {
            $form = array_merge($v, [
                'uuid' => Str::uuid()->toString(),
            ]);
            ViaPembayaran::create($form);
        }
    }
}
