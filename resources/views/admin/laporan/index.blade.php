<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.laporan.index') }}" method="GET" class="mb-6">
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Pilih Tanggal</label>
                        <div class="flex items-center space-x-2">
                            <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </form>

                    <h3 class="text-lg font-semibold mb-2">Ringkasan untuk tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <div class="text-sm text-green-700">Total Pendapatan</div>
                            <div class="text-3xl font-bold text-green-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <div class="text-sm text-blue-700">Total Pesanan Sukses</div>
                            <div class="text-3xl font-bold text-blue-900">{{ $totalPesanan }}</div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-2">Detail Transaksi</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pesananSelesai as $pesanan)
                                <tr>
                                    <td class="px-6 py-4 font-mono">{{ $pesanan->kode_pesanan }}</td>
                                    <td class="px-6 py-4">No. {{ $pesanan->meja->nomor_meja ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $pesanan->created_at->format('H:i:s') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data penjualan untuk tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>