<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPokok extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksiSimpanan';
    protected $fillable = ['id_simpanan_pokok','jatuh_tempo', 'tanggal_pembayaran', 'keterangan'];

    // Relasi dengan SimpananPokok
    public function simpananPokok(): BelongsTo
    {
        return $this->belongsTo(SimpananPokok::class, 'id_simpanan_pokok');
    }
}
