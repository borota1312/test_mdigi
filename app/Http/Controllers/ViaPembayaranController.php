<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestViaPembayaran;
use App\Models\ViaPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class ViaPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('via_pembayaran.index');
    }

    public function datatables(Request $request)
    {
        try {
            return (new ViaPembayaran())->datatable($request);
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
        return view('via_pembayaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestViaPembayaran $request)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            ViaPembayaran::create($data);
            session()->flash('success', 'Data Berhasil Disimpan.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('via_pembayaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $via_pembayaran = ViaPembayaran::query()->where('uuid', '=', $uuid)->firstOrFail();
        return view('via_pembayaran.edit', compact('via_pembayaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestViaPembayaran $request, string $uuid)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            $via_pembayaran = ViaPembayaran::query()->where('uuid', '=', $uuid)->firstOrFail();
            $via_pembayaran->update($data);
            session()->flash('success', 'Berhasil Mengubah Data.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('via_pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ViaPembayaran $via_pembayaran)
    {
        $via_pembayaran = ViaPembayaran::find($request->id);

        if (!$via_pembayaran) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $via_pembayaran->delete()
            ? response()->json(null, 204)
            : response()->json(['message' => 'Gagal menghapus data'], 400);
    }
}
