<?php

use App\Http\Controllers\RekeningController;
use Illuminate\Support\Facades\Route;

Route::controller(RekeningController::class)->prefix('rekening')->group(function () {
    Route::get('', 'index')->name('rekening');
    Route::get('create', 'create')->name('rekening.create');
    Route::post('store', 'store')->name('rekening.store');
    Route::get('edit/{uuid}', 'edit')->name('rekening.edit');
    Route::put('update/{uuid}', 'update')->name('rekening.update');
    Route::delete('destroy', 'destroy')->name('rekening.destroy');
    Route::post('datatables', 'datatables')->name('rekening.datatables');
});
