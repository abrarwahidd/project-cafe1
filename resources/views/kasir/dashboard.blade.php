<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kasir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-lg mb-4">Pesanan Masuk (Menunggu Pembayaran)</h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Pesan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pesanan-table-body" class="bg-white divide-y divide-gray-200">
                            @forelse ($pesanans as $pesanan)
                                <tr>
                                    <td class="px-6 py-4 font-mono">{{ $pesanan->kode_pesanan }}</td>
                                    <td class="px-6 py-4">No. {{ $pesanan->meja->nomor_meja }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $pesanan->created_at->format('H:i, d M Y') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('kasir.pesanan.show', $pesanan) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                            Lihat Detail & Validasi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr id='row-pesanan-kosong'>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada pesanan yang menunggu pembayaran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $pesanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- TAMBAHKAN KODE SCRIPT DI BAWAH INI --}}
@vite('resources/js/app.js')
<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        // Target elemen tabel
        const tableBody = document.getElementById('pesanan-table-body');
        const rowPesananKosong = document.getElementById('row-pesanan-kosong');

        window.Echo.channel('kasir-channel')
            .listen('.pesanan-baru', (e) => {
                console.log('Pesanan baru diterima!', e);

                // 1. Hapus pesan "kosong" jika ada
                if (rowPesananKosong) {
                    rowPesananKosong.remove();
                }

                // 2. Buat baris tabel (tr) baru
                const newRow = document.createElement('tr');
                newRow.className = 'bg-yellow-50 animate-pulse'; // Efek highlight sementara

                // 3. Isi konten untuk setiap sel (td)
                newRow.innerHTML = `
                    <td class="px-6 py-4 font-mono">${e.kode_pesanan}</td>
                    <td class="px-6 py-4">No. ${e.nomor_meja}</td>
                    <td class="px-6 py-4">${e.total_rupiah}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">${e.waktu_pesan}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="${e.detail_url}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                            Lihat Detail & Validasi
                        </a>
                    </td>
                `;

                // 4. Tambahkan baris baru ke bagian paling atas tabel
                tableBody.prepend(newRow);

                // 5. Hapus efek highlight setelah beberapa detik
                setTimeout(() => {
                    newRow.classList.remove('bg-yellow-50', 'animate-pulse');
                }, 5000);
            });
    });
</script>