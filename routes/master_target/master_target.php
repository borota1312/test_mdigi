<?php

use App\Http\Controllers\MasterTargetController;
use Illuminate\Support\Facades\Route;

Route::controller(MasterTargetController::class)->prefix('master_target')->group(function () {
    Route::get('', 'index')->name('master_target');
    Route::get('create', 'create')->name('master_target.create');
    Route::post('store', 'store')->name('master_target.store');
    Route::get('edit/{uuid}', 'edit')->name('master_target.edit');
    Route::put('update/{uuid}', 'update')->name('master_target.update');
    Route::delete('destroy', 'destroy')->name('master_target.destroy');
    Route::post('datatables', 'datatables')->name('master_target.datatables');
    // Route::get('{uuid}/cetak', 'cetak')->name('master_target.cetak');

});
