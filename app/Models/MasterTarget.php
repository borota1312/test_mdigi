<?php

namespace App\Models;

use App\Helpers\Datatables;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterTarget extends Model
{
    protected $table = 'master_targets';
    protected $fillable = ['uuid', 'rekening_id', 'target', 'berlaku_start', 'berlaku_end'];
    public $timestamps = true;
    public function datatable($request)
    {
        $columns = [
            'master_targets.id',
            'rekenings.kode_rekening',
            'rekenings.nama_rekening',
            'master_targets.target',
            'master_targets.berlaku_start',
            'master_targets.uuid'
        ];

        $columnIndex = $request->input('order.0.column', 0);

        $sortColumn = isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'master_targets.id';
        $sortDirection = $request->input('order.0.dir', 'desc');

        DB::statement("SET lc_time_names = 'id_ID'");

        $query = MasterTarget::query()
            ->select([
                'master_targets.id',
                'master_targets.rekening_id',
                'master_targets.target',
                DB::raw("DATE_FORMAT(master_targets.berlaku_start,'%m-%d-%Y') as berlaku_start"),
                DB::raw("DATE_FORMAT(master_targets.berlaku_end,'%m-%d-%Y') as berlaku_end"),
                'master_targets.uuid',
                'rekenings.kode_rekening',
                'rekenings.nama_rekening'
            ])
            ->leftJoin('rekenings', 'master_targets.rekening_id', '=', 'rekenings.id');

        if ($search = $request->input('search.value')) {
            $search = strtolower($search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(rekenings.kode_rekening) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(rekenings.nama_rekening) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($dateFilter = $request->input('tanggal')) {
            $date = Carbon::parse($dateFilter)->format('Y-m-d');
            $query->where(function ($q) use ($date) {
                $q->whereDate('master_targets.berlaku_start', $date)
                    ->orWhereDate('master_targets.berlaku_end', $date)
                    ->orWhere(function ($sq) use ($date) {
                        $sq->whereDate('master_targets.berlaku_start', '<=', $date)
                            ->whereDate('master_targets.berlaku_end', '>=', $date);
                    });
            });
        }

        return (new Datatables)->getDatatable($request, $query, $sortColumn, $sortDirection);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }
}
