<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-6">
                    Selamat datang, {{ Auth::user()->name }}!
                </h3>

                <p class="text-gray-600 mb-8">
                    Silakan pilih salah satu menu di bawah ini untuk mengelola sistem.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <a href="{{ route('admin.menus.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Atur Menu</h5>
                        <p class="font-normal text-gray-700">Tambah, edit, atau hapus menu makanan dan minuman.</p>
                    </a>

                    <a href="{{ route('admin.mejas.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Atur Meja & QR</h5>
                        <p class="font-normal text-gray-700">Kelola meja kafe dan cetak QR Code untuk pemesanan.</p>
                    </a>

                    <a href="{{ route('admin.laporan.index') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Laporan Penjualan</h5>
                        <p class="font-normal text-gray-700">Lihat total pendapatan dan riwayat transaksi harian.</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>