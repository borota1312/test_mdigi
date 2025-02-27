<?php

namespace App\Http\Controllers;

use App\Exports\EntryHarianExport;
use App\Http\Requests\RequestEntryHarian;
use App\Models\EntryHarian;
use App\Models\MasterTarget;
use App\Models\Rekening;
use App\Models\ViaPembayaran;
use App\Services\EntryHarianInterface;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class EntryHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vias = ViaPembayaran::all();
        return view('entry_harian.index', compact('vias'));
    }

    public function datatables(Request $request)
    {
        try {
            return (new EntryHarian())->datatable($request);
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
        $vias = ViaPembayaran::all();
        return view('entry_harian.create', compact('rekenings', 'vias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestEntryHarian $request)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            EntryHarian::create($data);
            session()->flash('success', 'Data Berhasil Disimpan.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('entry_harian');
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
        $entry = EntryHarian::query()->where('uuid', '=', $uuid)->firstOrFail();
        $rekenings = Rekening::all();
        $vias = ViaPembayaran::all();
        return view('entry_harian.edit', compact('entry', 'rekenings', 'vias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestEntryHarian $request, string $uuid)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            $entry = EntryHarian::query()->where('uuid', '=', $uuid)->firstOrFail();
            $entry->update($data);
            session()->flash('success', 'Berhasil Mengubah Data.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('entry_harian');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, EntryHarian $entry)
    {
        $entry = EntryHarian::find($request->id);

        if (!$entry) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $entry->delete()
            ? response()->json(null, 204)
            : response()->json(['message' => 'Gagal menghapus data'], 400);
    }

    public function excel(Request $request, EntryHarianInterface $entryService)
    {
        $data = $entryService->getData($request);
        return Excel::download(new EntryHarianExport($data), 'Entry_Harian.xlsx');
    }

    public function pdf(Request $request, EntryHarianInterface $entryService)
    {
        $data = $entryService->getData($request);
        $pdf = PDF::loadView('entry_harian.pdf', $data)->setPaper('A4', 'landscape');

        return $pdf->download('entry_harian.pdf');
    }
}
