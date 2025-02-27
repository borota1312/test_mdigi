<?php

namespace App\Exports;

use App\Models\MasterTarget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MasterTargetExport implements FromView
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('master_target.excel', $this->data);
    }
}
