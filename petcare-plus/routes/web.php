<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// Halaman Depan (Login)
Route::get('/', function () {
    return view('auth.login');
});

// Route untuk USER BIASA
Route::get('/dashboard', function () {
    // Jika admin login, redirect ke admin dashboard
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard'); // Tampilan User
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk ADMIN (Dilindungi Middleware 'admin')
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Route Simpan Hewan
    Route::post('/admin/pet', [AdminController::class, 'storePet'])->name('admin.pet.store');
    
    // Route Hapus Hewan
    Route::delete('/admin/pet/{id}', [AdminController::class, 'destroyPet'])->name('admin.pet.destroy');

    // Route Simpan Pemeriksaan (BARU)
    Route::post('/admin/checkup', [AdminController::class, 'storeCheckup'])->name('admin.checkup.store');
});

require __DIR__.'/auth.php';