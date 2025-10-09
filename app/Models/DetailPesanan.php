<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    // TAMBAHKAN BARIS INI
    protected $guarded = [];
    
    // Satu DetailPesanan milik satu Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}