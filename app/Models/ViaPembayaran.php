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
        $sortColumn = $columns[$request->input("order.0.column")];
        $data = ViaPembayaran::select([
            'id',
            'nama',
            'uuid'
        ]);
        if (request()->input("search.value")) {
            $search = strtolower(request()->input("search.value"));
            $data = $data->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(nama) like ?', "%$search%");
            });
        }
        return (new Datatables)->getDatatable($request, $data, $sortColumn);
    }
}
