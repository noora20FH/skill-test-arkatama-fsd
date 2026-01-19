<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    // Daftar kolom yang boleh diisi manual
    protected $fillable = [
        'name',
        'phone',
        'is_verified',
    ];

    // Relasi ke Pets
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
