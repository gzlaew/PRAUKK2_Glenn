<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Fortify\ListUsers;
use App\Actions\Fortify\ShowCreateUserForm;
use App\Actions\Fortify\StoreUser;
use App\Actions\Fortify\ShowEditUserForm;
use App\Actions\Fortify\UpdateUser;
use App\Actions\Fortify\DeleteUser;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('welcome');
});

// Group pertama: butuh login, TAPI tidak butuh verifikasi email
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified' -- DIHAPUS di sini jika Anda ingin user bisa akses tanpa verifikasi
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route biasa ke "/page/user"
    Route::get('/page/user', function () {
        // Pastikan "resources/views/user.blade.php" ada
        return view('user');
    })->name('user');
});

Route::get('/shift', [ShiftController::class, 'index'])->name('shift.index');
Route::resource('service', ServiceController::class);

// Endpoint untuk ambil data shift (dipanggil lewat AJAX)
Route::get('/shifts', [ShiftController::class, 'getShifts'])->name('shifts.get');
Route::post('/shifts/store', [ShiftController::class, 'store'])->name('shifts.store');

Route::get('/shifts/{id}/edit', [ShiftController::class, 'edit'])->name('shift.edit');

// Rute Update (menyimpan perubahan)
Route::put('/shifts/{id}', [ShiftController::class, 'update'])->name('shift.update');
Route::resource('sparepart', SparepartController::class);
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');


// Rute Delete (menghapus shift)
Route::delete('/shifts/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
Route::post('/alat/store', [AlatController::class, 'store'])->name('alat.store');
Route::get('/alat/{id}/edit', [AlatController::class, 'edit'])->name('alat.edit');
Route::put('/alat/{id}', [AlatController::class, 'update'])->name('alat.update');
Route::delete('/alat/{id}', [AlatController::class, 'destroy'])->name('alat.destroy');
Route::post('/sparepart/addStock', [SparepartController::class, 'addStock'])->name('sparepart.addStock');


Route::resource('jamkerja', JamKerjaController::class);

// Group kedua: butuh login & email terverifikasi
// Di sinilah Action CRUD user (List, Create, dsb.)
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('jamkerja', JamKerjaController::class);
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/return/{id}', [PeminjamanController::class, 'returnItem'])->name('peminjaman.return');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});
