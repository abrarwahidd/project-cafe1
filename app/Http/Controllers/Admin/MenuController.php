<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Import Storage

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(10); // Ambil semua menu, urutkan dari yg terbaru
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minuman',
            'status' => 'required|in:tersedia,habis',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('public/menus');
            $validated['gambar'] = $path;
        }

        Menu::create($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minuman',
            'status' => 'required|in:tersedia,habis',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($menu->gambar) {
                Storage::delete($menu->gambar);
            }
            $path = $request->file('gambar')->store('public/menus');
            $validated['gambar'] = $path;
        }

        $menu->update($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        // Hapus gambar dari storage
        if ($menu->gambar) {
            Storage::delete($menu->gambar);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}