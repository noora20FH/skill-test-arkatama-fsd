<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    // Tambahkan ini untuk memperbaiki error MassAssignmentException
    protected $fillable = [
        'owner_id',
        'code',
        'name',
        'type',
        'age',
        'weight',
    ];

    // Relasi ke Owner (Opsional tapi penting untuk project ini)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}
