<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    protected $fillable = ['owner_id', 'code', 'name', 'type', 'age', 'weight'];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    // Relasi: 1 Hewan punya banyak Pemeriksaan
    public function checkups() {
        return $this->hasMany(Checkup::class);
    }
}