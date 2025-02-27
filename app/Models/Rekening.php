<?php

namespace App\Models;

use App\Helpers\Datatables;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekenings';
    protected $fillable = ['uuid', 'kode_rekening', 'nama_rekening'];
    public $timestamps = true;

    public function datatable($request)
    {
        $columns = [
            'id',
            'kode_rekening',
            'nama_rekening',
            'uuid'
        ];

        $columnIndex = $request->input('order.0.column', 0);

        $sortColumn = isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'rekenings.id';
        $sortDirection = $request->input('order.0.dir', 'desc');
        $query = Rekening::select([
            'rekenings.*'
        ]);
        if (request()->input("search.value")) {
            $search = strtolower(request()->input("search.value"));
            $query = $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_rekening) like ?', "%$search%")
                    ->orWhereRaw('LOWER(nama_rekening) like ?', "%$search%");
            });
        }
        return (new Datatables)->getDatatable($request, $query, $sortColumn, $sortDirection);
    }
}
