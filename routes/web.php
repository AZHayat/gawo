<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderStatusController;

// Route untuk halaman utama
Route::get('/', function () {
    return view('home'); // Menampilkan halaman utama (home)
});

// Grup Route untuk Work Order
Route::prefix('workorder')->group(function () {
    
    // Route untuk menampilkan halaman pembuatan Work Order
    Route::get('/create', [WorkOrderController::class, 'create'])->name('workorder.create');
    
    // Route untuk menyimpan data Work Order ke database
    Route::post('/store', [WorkOrderController::class, 'store'])->name('workorder.store');

    // Route untuk menampilkan halaman update Work Order
    Route::get('/update', [WorkOrderController::class, 'edit'])->name('workorder.edit');

    // Route untuk memproses update data Work Order
    Route::patch('/update', [WorkOrderController::class, 'update'])->name('workorder.update');

    // Route untuk halaman status Work Order 
    // Route::get('/status', function () {
    //     return "Halaman Status WO"; // Placeholder sementara
    // })->name('workorder.status');

    Route::get('/status', [WorkOrderStatusController::class, 'index'])->name('workorder.status');

    // Route untuk mencari Work Order berdasarkan nomor WO (digunakan untuk AJAX search)
    Route::post('/find', [WorkOrderController::class, 'find'])->name('workorder.find');

    //Route Hapus WO
    Route::post('/workorder/delete', [WorkOrderController::class, 'delete'])->name('workorder.delete');
    

});



