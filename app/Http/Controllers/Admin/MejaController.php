<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Meja::orderBy('nomor_meja')->get();
        return view('admin.meja.index', compact('mejas'));
    }

    public function create()
    {
        return view('admin.meja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|integer|unique:mejas,nomor_meja',
            'kode_meja' => 'required|string|unique:mejas,kode_meja',
        ]);

        Meja::create($validated);

        return redirect()->route('admin.mejas.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }

    public function edit(Meja $meja)
    {
        return view('admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, Meja $meja)
    {
        $validated = $request->validate([
            'nomor_meja' => 'required|integer|unique:mejas,nomor_meja,' . $meja->id,
            'kode_meja' => 'required|string|unique:mejas,kode_meja,' . $meja->id,
        ]);

        $meja->update($validated);

        return redirect()->route('admin.mejas.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    public function destroy(Meja $meja)
    {
        // Pengecekan keamanan: jangan hapus meja jika ada pesanan terkait (opsional tapi bagus)
        if ($meja->pesanans()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus meja yang sudah memiliki riwayat pesanan.');
        }

        $meja->delete();
        return redirect()->route('admin.mejas.index')->with('success', 'Meja berhasil dihapus.');
    }

    public function showQr(Meja $meja)
    {
        // Dapatkan URL lengkap yang akan diarahkan oleh QR code
        $url = route('pesan.menu', $meja);

        return view('admin.meja.qr', compact('meja', 'url'));
    }
}