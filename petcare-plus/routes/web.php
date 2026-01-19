<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController; // Perlu buat controller ini
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

// Route User Biasa
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Halaman Khusus Data Hewan
    Route::get('/admin/pets', [AdminController::class, 'petIndex'])->name('admin.pets.index');
    
    // CRUD Hewan
    Route::post('/admin/pet', [AdminController::class, 'storePet'])->name('admin.pet.store');
    Route::delete('/admin/pet/{id}', [AdminController::class, 'destroyPet'])->name('admin.pet.destroy');

    // CRUD Pemilik (Resource otomatis membuat index, store, destroy, dll)
    Route::resource('/admin/owners', OwnerController::class);
});

require __DIR__.'/auth.php';