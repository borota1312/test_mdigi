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
            'id',
            'rekening_id',
            'target',
            'berlaku_start',
            'uuid'
        ];
        $sortColumn = $columns[$request->input("order.0.column")];
        $data = MasterTarget::query()->select([
            'id',
            'rekening_id',
            'target',
            DB::raw("(DATE_FORMAT(berlaku_start,'%m-%d-%Y', 'id_ID')) as berlaku_start"),
            DB::raw("(DATE_FORMAT(berlaku_end,'%m-%d-%Y', 'id_ID')) as berlaku_end"),
            'uuid'
        ]);
        $data = $data->with('rekening');
        if (request()->input("search.value")) {
            $search = strtolower(request()->input("search.value"));
            $data = $data->whereHas('rekening', function ($query) use ($search) {
                $query->whereRaw('LOWER(kode_rekening) like ?', "%$search%")
                    ->orWhereRaw('LOWER(nama_rekening) like ?', "%$search%");
            });
        }
        if (request()->input("tanggal") !== null) {
            $date = Carbon::parse(request()->input("tanggal"))->format('Y-m-d');
            $data->where(function ($query) use ($date) {
                $query->whereDate('berlaku_start', $date)
                    ->orWhereDate('berlaku_end', $date)
                    ->orWhere(function ($subquery) use ($date) {
                        $subquery->whereDate('berlaku_start', '<=', $date)
                            ->whereDate('berlaku_end', '>=', $date);
                    });
            });
        }
        return (new Datatables)->getDatatable($request, $data, $sortColumn);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id', 'id');
    }
}
