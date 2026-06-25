<?php

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dispatches to the dashboard that matches the logged-in user's role.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === Role: Siswa / Orang Tua ===
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
    Route::get('/izin', [LeaveRequestController::class, 'index'])->name('izin.index');
    Route::get('/izin/create', [LeaveRequestController::class, 'create'])->name('izin.create');
    Route::post('/izin', [LeaveRequestController::class, 'store'])->name('izin.store');
    Route::get('/izin/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('izin.show');
});

// === Role: Guru / Wali Kelas ===
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
    Route::get('/persetujuan', [ApprovalController::class, 'index'])->name('persetujuan.index');
    Route::get('/persetujuan/{leaveRequest}', [ApprovalController::class, 'show'])->name('persetujuan.show');
    Route::patch('/persetujuan/{leaveRequest}', [ApprovalController::class, 'update'])->name('persetujuan.update');
});

// === Role: Admin  ===
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('pengguna', UserController::class)->except(['show']);
    Route::put('/pengguna/{pengguna}/reset-password', [UserController::class, 'resetPassword'])->name('pengguna.reset-password');
    Route::get('/rekap', [ReportController::class, 'index'])->name('rekap.index');
    Route::get('/rekap/export', [ReportController::class, 'export'])->name('rekap.export');
});

require __DIR__.'/auth.php';
