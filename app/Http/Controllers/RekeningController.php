<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestRekening;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rekening.index');
    }

    public function datatables(Request $request)
    {
        try {
            return (new Rekening())->datatable($request);
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
        return view('rekening.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestRekening $request)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            Rekening::create($data);
            session()->flash('success', 'Data Berhasil Disimpan.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('rekening');
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
        $rekening = Rekening::query()->where('uuid', '=', $uuid)->firstOrFail();
        return view('rekening.edit', compact('rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestRekening $request, string $uuid)
    {
        $validate = $request->validated();
        $data = array_merge($validate, [
            'uuid' => Str::uuid()->toString(),
        ]);
        try {
            $rekening = Rekening::query()->where('uuid', '=', $uuid)->firstOrFail();
            $rekening->update($data);
            session()->flash('success', 'Berhasil Mengubah Data.');
        } catch (Throwable $e) {
            report($e);
            session()->flash('error', $e->getMessage());
        }
        return to_route('rekening');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Rekening $rekening)
    {
        $rekening = Rekening::find($request->id);

        if (!$rekening) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return $rekening->delete()
            ? response()->json(null, 204)
            : response()->json(['message' => 'Gagal menghapus data'], 400);
    }
}
