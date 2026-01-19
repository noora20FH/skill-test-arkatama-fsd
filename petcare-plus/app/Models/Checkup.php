<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    protected $fillable = ['pet_id', 'treatment_id', 'notes'];

    public function pet() {
        return $this->belongsTo(Pet::class);
    }

    // Relasi: 1 Pemeriksaan punya 1 Jenis Treatment
    public function treatment() {
        return $this->belongsTo(Treatment::class);
    }
}
