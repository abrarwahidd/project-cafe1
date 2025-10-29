<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pesanan; // <-- PENTING: Import model Pesanan

class Meja extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Ini mengizinkan semua kolom di tabel 'mejas' untuk diisi
     * melalui form (PENTING UNTUK FITUR TAMBAH/EDIT MEJA).
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Mendefinisikan relasi one-to-many ke Pesanan.
     * (Untuk pengecekan keamanan saat menghapus meja).
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_meja');
    }
}