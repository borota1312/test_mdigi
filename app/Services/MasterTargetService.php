<?php

namespace App\Services;

use App\Models\MasterTarget;
use Carbon\Carbon;

class MasterTargetService implements MasterTargetInterface
{
    public function getData($request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        if ($request->has('filter')) {
            $date = Carbon::parse($request->filter)->format('Y-m-d');
        }
        $masters = MasterTarget::query()->where(function ($q) use ($date) {
            $q->where('berlaku_start', $date)
                ->orWhere('berlaku_end', $date)
                ->orWhere(function ($sq) use ($date) {
                    $sq->where('berlaku_start', '<=', $date)
                        ->where('berlaku_end', '>=', $date);
                });
        })->get();
        $tanggal = Carbon::parse($date)->translatedFormat('d F Y');
        $tahun = Carbon::parse($date)->format('Y');
        $data = [
            'masters' => $masters,
            'tanggal' => $tanggal,
            'tahun' => $tahun
        ];
        return $data;
    }
}
