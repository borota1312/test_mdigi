<?php

use App\Http\Controllers\ViaPembayaranController;
use Illuminate\Support\Facades\Route;

Route::controller(ViaPembayaranController::class)->prefix('via_pembayaran')->group(function () {
    Route::get('', 'index')->name('via_pembayaran');
    Route::get('create', 'create')->name('via_pembayaran.create');
    Route::post('store', 'store')->name('via_pembayaran.store');
    Route::get('edit/{uuid}', 'edit')->name('via_pembayaran.edit');
    Route::put('update/{uuid}', 'update')->name('via_pembayaran.update');
    Route::delete('destroy', 'destroy')->name('via_pembayaran.destroy');
    Route::post('datatables', 'datatables')->name('via_pembayaran.datatables');
    // Route::get('{uuid}/cetak', 'cetak')->name('sph.cetak');

});
