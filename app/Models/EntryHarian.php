<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryHarian extends Model
{
    protected $table = 'entry_harians';
    protected $fillable = ['uuid', 'rekening_id', 'via_id', 'jumlah_bayar', 'tanggal_setor'];
    public $timestamps = true;
}
