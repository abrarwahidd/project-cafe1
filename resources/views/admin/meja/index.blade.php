<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Meja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.mejas.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Tambah Meja Baru
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Meja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Meja (Unik)</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($mejas as $meja)
                                <tr>
                                    <td class="px-6 py-4">{{ $meja->nomor_meja }}</td>
                                    <td class="px-6 py-4 font-mono">{{ $meja->kode_meja }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.meja.qr', $meja) }}" target="_blank" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-3 rounded text-sm">
                                            Lihat QR Code
                                        </a>
                                        <a href="{{ route('admin.mejas.edit', $meja) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                        <form action="{{ route('admin.mejas.destroy', $meja) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus meja ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data meja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>