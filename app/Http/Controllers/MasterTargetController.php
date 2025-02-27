<?php

namespace App\Http\Controllers;

use App\Exports\MasterTargetExport;
use App\Http\Requests\RequestMasterTarget;
use App\Models\MasterTarget;
use App\Models\Rekening;
use App\Services\MasterTargetInterface;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class MasterTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master_target.index');
    }

    public function datatables(Request $request)
    {
        try {
            return (new MasterTarget())->datatable($request);
        } catch (Throwable $e) {
            report($e);
            return session()->flash('error', $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rekenings = Rekening::all();
        return view('master_target.create', compact('rekenings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestMasterTarget $request)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            MasterTarget::create($data);
            session()->flash('success', 'Data Berhasil Disimpan.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('master_target');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $rekenings = Rekening::all();
        $master = MasterTarget::query()->where('uuid', '=', $uuid)->firstOrFail();
        return view('master_target.edit', compact('master', 'rekenings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestMasterTarget $request, string $uuid)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            $master = MasterTarget::query()->where('uuid', '=', $uuid)->firstOrFail();
            $master->update($data);
            session()->flash('success', 'Berhasil Mengubah Data.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('master_target');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, MasterTarget $master)
    {
        $master = MasterTarget::find($request->id);

        if (!$master) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $master->delete()
            ? response()->json(null, 204)
            : response()->json(['message' => 'Gagal menghapus data'], 400);
    }

    public function excel(Request $request, MasterTargetInterface $masterService)
    {
        $data = $masterService->getData($request);
        return Excel::download(new MasterTargetExport($data), 'Master_Target.xlsx');
    }
    public function pdf(Request $request, MasterTargetInterface $masterService)
    {
        $data = $masterService->getData($request);
        $pdf = PDF::loadView('master_target.pdf', $data)->setPaper('A4', 'landscape');

        return $pdf->download('master_target.pdf');
    }
}
