<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tanggungan extends Model
{
    use HasFactory;

    protected $table = 'tanggungan';
    protected $primarKey = 'id_tanggungan';
    protected $guarded = [];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_pinjaman');
    }

    public function pinjaman(): BelongsTo{
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }
}
