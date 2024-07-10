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
    public $timestamps = false;
    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjaman';
    protected $fillable = ['id_user', 'tgl_pengajuan', 'besar_pinjaman', 'tenor_pinjaman', 'keterangan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function tanggungan(): HasOne
    {
        return $this->hasOne(Tanggungan::class, 'id_Pinjaman', 'id_pinjaman');
    }
}