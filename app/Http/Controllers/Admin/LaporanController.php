<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan.
     */
    public function index(Request $request)
    {
        // Set tanggal default ke hari ini jika tidak ada input
        $tanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));

        // Ambil pesanan yang SUDAH DIBAYAR (diproses) atau selesai
        // berdasarkan tanggal yang dipilih
        $pesananSelesai = Pesanan::whereIn('status', ['diproses', 'selesai'])
                                ->whereDate('created_at', $tanggal)
                                ->with('meja') // Ambil data meja juga
                                ->get();

        // Hitung total pendapatan
        $totalPendapatan = $pesananSelesai->sum('total_harga');
        $totalPesanan = $pesananSelesai->count();

        // Kirim data ke view
        return view('admin.laporan.index', compact(
            'totalPendapatan', 
            'totalPesanan', 
            'tanggal', 
            'pesananSelesai'
        ));
    }
}