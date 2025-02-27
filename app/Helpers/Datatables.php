<?php

namespace App\Helpers;

class Datatables
{
    public function getDatatable($request, $query, $sortColumn = null, $sortDirection = null)
    {
        $totalRecords = $query->count();

        if ($sortColumn) {
            $direction = $sortDirection ?? $request->input('order.0.dir', 'asc');
            $query->orderBy($sortColumn, $direction);
        }

        $totalFiltered = $query->count();

        if ($request->input('length') != -1) {
            $query->skip($request->input('start'))->take($request->input('length'));
        }

        $data = $query->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
}
