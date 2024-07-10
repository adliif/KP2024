<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SimpananPokok extends Model
{
    use HasFactory;

    protected $primarKey = 'id_simpanan_pokok';
    protected $fillable = ['iuran', 'total_simpanan_pokok'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }
}