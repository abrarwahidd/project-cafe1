<?php

namespace App\Http\Controllers\Kasir;

use App\Events\PesananDivalidasi;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan daftar pesanan yang menunggu pembayaran
    public function index()
    {
        $pesanans = Pesanan::where('status', 'menunggu_pembayaran')
                            ->latest()
                            ->paginate(10);
        
        return view('kasir.dashboard', compact('pesanans'));
    }

    // Menampilkan detail satu pesanan
    public function show(Pesanan $pesanan)
    {
        // Eager loading untuk mengambil detail pesanan dan menu sekaligus (lebih efisien)
        $pesanan->load('detailPesanans.menu');

        return view('kasir.show', compact('pesanan'));
    }

    // Memvalidasi pembayaran
    public function validasi(Pesanan $pesanan)
    {
        // Ubah status pesanan
        $pesanan->status = 'diproses';
        $pesanan->save();

        // TEMBAKKAN EVENT SETELAH BERHASIL DISIMPAN
        PesananDivalidasi::dispatch($pesanan);

        // Redirect kembali ke dashboard kasir dengan pesan sukses
        return redirect()->route('kasir.dashboard')->with('success', 'Pesanan ' . $pesanan->kode_pesanan . ' berhasil divalidasi.');
    }
}