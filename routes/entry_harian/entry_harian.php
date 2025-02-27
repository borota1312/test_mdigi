<?php

use App\Http\Controllers\EntryHarianController;
use Illuminate\Support\Facades\Route;

Route::controller(EntryHarianController::class)->prefix('entry_harian')->group(function () {
    Route::get('', 'index')->name('entry_harian');
    Route::get('create', 'create')->name('entry_harian.create');
    Route::post('store', 'store')->name('entry_harian.store');
    Route::get('edit/{uuid}', 'edit')->name('entry_harian.edit');
    Route::put('update/{uuid}', 'update')->name('entry_harian.update');
    Route::delete('destroy', 'destroy')->name('entry_harian.destroy');
    Route::post('datatables', 'datatables')->name('entry_harian.datatables');
    Route::get('excel', 'excel')->name('entry_harian.excel');
    Route::get('pdf', 'pdf')->name('entry_harian.pdf');
});
