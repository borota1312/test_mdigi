<?php

namespace App\Exports;

use App\Models\EntryHarian;
use App\Models\MasterTarget;
use App\Models\ViaPembayaran;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EntryHarianExport implements FromView
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('entry_harian.excel', $this->data);
    }
}
