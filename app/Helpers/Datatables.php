<?php

namespace App\Helpers;

class Datatables
{
    public function getDatatable($request, $query, $sortColumn)
    {
        $totalFiltered = $query->get()->count();
        if ($request->input('length') != -1) {
            $query = $query->skip($request->input('start'))->take($request->input('length'));
        }
        $sortedData = $query->orderBy($sortColumn, $request->input('order.0.dir'))->get();
        $totalRecords = $sortedData->count();

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $sortedData,
        ]);
    }
}
