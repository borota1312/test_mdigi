<?php

namespace App\Services;

use App\Models\MasterTarget;
use App\Models\EntryHarian;
use App\Models\ViaPembayaran;
use Carbon\Carbon;

class EntryHarianService implements EntryHarianInterface
{
    public function getData($request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        if ($request->has('filter')) {
            $date = Carbon::parse($request->filter)->format('Y-m-d');
        }
        $bulan_now = Carbon::parse($date)->month;
        $tahun_now = Carbon::parse($date)->year;

        $get_masters = MasterTarget::query()
            ->where(function ($q) use ($date) {
                $q->where('berlaku_start', $date)
                    ->orWhere('berlaku_end', $date)
                    ->orWhere(function ($sq) use ($date) {
                        $sq->where('berlaku_start', '<=', $date)
                            ->where('berlaku_end', '>=', $date);
                    });
            })->get();

        $masters = [];
        $via_bayar = '';
        $total_target = 0;
        $total_bulan_ini = 0;
        $total_sd_bulan_lalu = 0;
        $total_sd_bulan_ini = 0;
        $total_persen = 0;
        foreach ($get_masters as $key => $value) {
            $bulan_ini = EntryHarian::query()->where('rekening_id', '=', $value->rekening_id)
                ->whereYear('tanggal_setor', '=', $tahun_now)
                ->whereMonth('tanggal_setor', '=', $bulan_now)
                ->where('tanggal_setor', '>=', $value->berlaku_start)
                ->where('tanggal_setor', '<=', $value->berlaku_end)
                ->where('tanggal_setor', '<=', $date);
            $sd_bulan_lalu = EntryHarian::query()->where('rekening_id', '=', $value->rekening_id)
                ->whereYear('tanggal_setor', '=', $tahun_now)
                ->whereMonth('tanggal_setor', '<', $bulan_now)
                ->where('tanggal_setor', '>=', $value->berlaku_start)
                ->where('tanggal_setor', '<=', $value->berlaku_end)
                ->where('tanggal_setor', '<=', $date);
            $sd_bulan_ini = EntryHarian::query()->where('rekening_id', '=', $value->rekening_id)
                ->whereYear('tanggal_setor', '=', $tahun_now)
                ->whereMonth('tanggal_setor', '<=', $bulan_now)
                ->where('tanggal_setor', '>=', $value->berlaku_start)
                ->where('tanggal_setor', '<=', $value->berlaku_end)
                ->where('tanggal_setor', '<=', $date);

            if ($request->input('via_bayar') != '') {
                $via_bayar = ViaPembayaran::query()->where('id', $request->input('via_bayar'))->value('nama');
                $bulan_ini = $bulan_ini->where('via_id', '=', $request->input('via_bayar'));
                $sd_bulan_lalu = $sd_bulan_lalu->where('via_id', '=', $request->input('via_bayar'));
                $sd_bulan_ini = $sd_bulan_ini->where('via_id', '=', $request->input('via_bayar'));
            }

            $bulan_ini = $bulan_ini->sum('jumlah_bayar');
            $sd_bulan_lalu = $sd_bulan_lalu->sum('jumlah_bayar');
            $sd_bulan_ini = $sd_bulan_ini->sum('jumlah_bayar');
            $persen = $sd_bulan_ini / $value->target * 100;

            $total_target += $value->target;
            $total_bulan_ini += $bulan_ini;
            $total_sd_bulan_lalu += $sd_bulan_lalu;
            $total_sd_bulan_ini += $sd_bulan_ini;
            $total_persen = $total_sd_bulan_ini / $total_target * 100;
            $masters[] = [
                'kode_rekening' => $value->rekening->kode_rekening,
                'nama_rekening' => $value->rekening->nama_rekening,
                'target' => number_format($value->target, 0, ',', '.'),
                'bulan_ini' => number_format($bulan_ini, 0, ',', '.'),
                'sd_bulan_lalu' => number_format($sd_bulan_lalu, 0, ',', '.'),
                'sd_bulan_ini' => number_format($sd_bulan_ini, 0, ',', '.'),
                'persen' => round($persen, 2)
            ];
        }

        $tanggal = Carbon::parse($date)->translatedFormat('d F Y');
        $tahun = Carbon::parse($date)->format('Y');

        $data = [
            'masters' => $masters,
            'tanggal' => $tanggal,
            'tahun' => $tahun,
            'via_bayar' => $via_bayar != '' ? 'VIA ' . strtoupper($via_bayar) : '',
            'total_target' => number_format($total_target, 0, ',', '.'),
            'total_bulan_ini' => number_format($total_bulan_ini, 0, ',', '.'),
            'total_sd_bulan_lalu' => number_format($total_sd_bulan_lalu, 0, ',', '.'),
            'total_sd_bulan_ini' => number_format($total_sd_bulan_ini, 0, ',', '.'),
            'total_persen' => round($total_persen, 2),
        ];
        return $data;
    }
}
