<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});
require __DIR__ . '/rekening/rekening.php';
require __DIR__ . '/via_pembayaran/via_pembayaran.php';
require __DIR__ . '/master_target/master_target.php';
