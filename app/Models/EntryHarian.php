<?php

namespace App\Models;

use App\Helpers\Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EntryHarian extends Model
{
    protected $table = 'entry_harians';
    protected $fillable = ['uuid', 'rekening_id', 'via_id', 'jumlah_bayar', 'tanggal_setor'];
    public $timestamps = true;
    public function datatable($request)
    {
        $columns = [
            'entry_harians.id',
            'rekenings.kode_rekening',
            'rekenings.nama_rekening',
            'via_pembayarans.nama',
            'entry_harians.tanggal_setor',
            'entry_harians.jumlah_bayar',
            'entry_harians.uuid'
        ];

        $columnIndex = $request->input('order.0.column', 0);

        $sortColumn = isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'entry_harians.id';
        $sortDirection = $request->input('order.0.dir', 'desc');

        DB::statement("SET lc_time_names = 'id_ID'"); //set tanggal bhs indo

        $query = EntryHarian::query()
            ->select([
                'entry_harians.id',
                'entry_harians.rekening_id',
                'entry_harians.via_id',
                'entry_harians.jumlah_bayar',
                DB::raw("DATE_FORMAT(entry_harians.tanggal_setor,'%e %b %Y') as tanggal_setor"),
                'entry_harians.uuid',
                'rekenings.kode_rekening',
                'rekenings.nama_rekening',
                'via_pembayarans.nama'
            ])
            ->leftJoin('rekenings', 'entry_harians.rekening_id', '=', 'rekenings.id')
            ->leftJoin('via_pembayarans', 'entry_harians.via_id', '=', 'via_pembayarans.id');

        if ($search = $request->input('search.value')) {
            $search = strtolower($search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(rekenings.kode_rekening) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(rekenings.nama_rekening) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(via_pembayarans.nama) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($dateFilter = $request->input('tanggal')) {
            $date = Carbon::parse($dateFilter)->format('Y-m-d');
            $bulan_now = Carbon::parse($date)->month;
            $tahun_now = Carbon::parse($date)->year;
            $query->whereYear('entry_harians.tanggal_setor', '=', $tahun_now)
                ->whereMonth('entry_harians.tanggal_setor', '<=', $bulan_now)
                ->where('entry_harians.tanggal_setor', '<=', $date);
        }
        if ($viaBayar = $request->input('via_bayar')) {
            $query->where('entry_harians.via_id', '=', $viaBayar);
        }

        return (new Datatables)->getDatatable($request, $query, $sortColumn, $sortDirection);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }
    public function via_bayar()
    {
        return $this->belongsTo(ViaPembayaran::class, 'via_id', 'id');
    }
}
