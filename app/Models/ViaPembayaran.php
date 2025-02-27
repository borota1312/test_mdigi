<?php

namespace App\Models;

use App\Helpers\Datatables;
use Illuminate\Database\Eloquent\Model;

class ViaPembayaran extends Model
{
    protected $table = 'via_pembayarans';
    protected $fillable = ['uuid', 'nama'];
    public $timestamps = true;

    public function datatable($request)
    {
        $columns = [
            'id',
            'nama',
            'uuid'
        ];

        $columnIndex = $request->input('order.0.column', 0);

        $sortColumn = isset($columns[$columnIndex]) ? $columns[$columnIndex] : 'via_pembayarans.id';
        $sortDirection = $request->input('order.0.dir', 'desc');
        $query = ViaPembayaran::select([
            'via_pembayarans.*'
        ]);
        if (request()->input("search.value")) {
            $search = strtolower(request()->input("search.value"));
            $query = $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) like ?', "%$search%");
            });
        }
        return (new Datatables)->getDatatable($request, $query, $sortColumn, $sortDirection);
    }
}
