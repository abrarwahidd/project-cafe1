<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    // TAMBAHKAN BARIS INI
    protected $guarded = [];

    // Satu Pesanan milik satu Meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja');
    }

    // Satu Pesanan memiliki banyak DetailPesanan
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}