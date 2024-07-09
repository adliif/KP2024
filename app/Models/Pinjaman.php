<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjaman';
    protected $fillable = ['total_pinjaman', 'tgl_pinjaman', 'status_pinjaman'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function tanggungan(): HasOne{
        return $this->hasOne(Tanggungan::class, 'id_Pinjaman', 'id_pinjaman');
    }
}
