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
        $sortColumn = $columns[$request->input("order.0.column")];
        $data = Rekening::select([
            'id',
            'kode_rekening',
            'nama_rekening',
            'uuid'
        ]);
        if (request()->input("search.value")) {
            $search = strtolower(request()->input("search.value"));
            $data = $data->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(kode_rekening) like ?', "%$search%")
                    ->orWhereRaw('LOWER(nama_rekening) like ?', "%$search%");
            });
        }
        return (new Datatables)->getDatatable($request, $data, $sortColumn);
    }
}
