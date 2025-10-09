<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan: {{ $pesanan->kode_pesanan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Pesanan</dt>
                            <dd class="mt-1 text-lg font-mono font-semibold">{{ $pesanan->kode_pesanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Meja</dt>
                            <dd class="mt-1 text-lg font-semibold">No. {{ $pesanan->meja->nomor_meja }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Pembayaran</dt>
                            <dd class="mt-1 text-lg font-semibold text-blue-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</dd>
                        </div>
                    </div>

                    <h3 class="font-semibold text-md mb-2 border-t pt-4">Rincian Item:</h3>
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach ($pesanan->detailPesanans as $detail)
                        <li class="flex py-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $detail->menu->gambar ? Storage::url($detail->menu->gambar) : 'https://via.placeholder.com/150' }}" alt="{{ $detail->menu->nama }}" class="h-16 w-16 rounded-md object-cover">
                            </div>
                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>{{ $detail->menu->nama }}</h3>
                                        <p class="ml-4">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                    <p class="text-gray-500">Jumlah: {{ $detail->jumlah }}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="border-t pt-6 mt-6">
                        <form action="{{ route('kasir.pesanan.validasi', $pesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin pembayaran sudah diterima dan sesuai?');">
                            @csrf
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('kasir.dashboard') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Kembali</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Konfirmasi Pembayaran Telah Diterima
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>