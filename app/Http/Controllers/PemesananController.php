<?php

namespace App\Http\Controllers;

use App\Events\PesananDibuat;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananController extends Controller
{
    // Menampilkan halaman menu untuk meja tertentu
    public function showMenu(Meja $meja)
    {
        $menus = Menu::where('status', 'tersedia')->get()->groupBy('kategori');
        return view('pesan.menu', compact('meja', 'menus'));
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'id_meja' => 'required|exists:mejas,id',
            'cart' => 'required|json',
        ]);

        $cart = json_decode($request->cart, true);

        // Memulai transaksi database
        // Ini memastikan jika ada satu query yg gagal, semua akan dibatalkan (data aman)
        $pesanan = DB::transaction(function () use ($request, $cart) {
            $meja = Meja::find($request->id_meja);

            // 1. Buat Kode Pesanan Unik (misal: M01-001)
            $todayOrderCount = Pesanan::where('id_meja', $meja->id)
                ->whereDate('created_at', Carbon::today())->count();
            $kodePesanan = strtoupper($meja->kode_meja) . '-' . str_pad($todayOrderCount + 1, 3, '0', STR_PAD_LEFT);

            // 2. Hitung Total Harga
            $totalHarga = 0;
            foreach ($cart as $item) {
                $totalHarga += $item['harga'] * $item['jumlah'];
            }

            // 3. Simpan data Pesanan
            $pesanan = Pesanan::create([
                'id_meja' => $meja->id,
                'kode_pesanan' => $kodePesanan,
                'total_harga' => $totalHarga,
                'status' => 'menunggu_pembayaran',
            ]);

            // 4. Simpan data Detail Pesanan
            foreach ($cart as $item) {
                $pesanan->detailPesanans()->create([
                    'id_menu' => $item['id'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga'] * $item['jumlah'],
                ]);
            }

            return $pesanan;
        });

        // TEMBAKKAN EVENT SETELAH TRANSAKSI BERHASIL
        PesananDibuat::dispatch($pesanan);

        return response()->json(['redirect_url' => route('pesan.sukses', $pesanan)]);
    }

    // Menampilkan halaman sukses
    public function showSukses(Pesanan $pesanan)
    {
        return view('pesan.sukses', compact('pesanan'));
    }
}