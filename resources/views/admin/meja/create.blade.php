<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Meja Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.mejas.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nomor_meja" class="block text-sm font-medium text-gray-700">Nomor Meja (Cth: 1, 2, 3)</label>
                            <input type="number" name="nomor_meja" id="nomor_meja" value="{{ old('nomor_meja') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('nomor_meja') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kode_meja" class="block text-sm font-medium text-gray-700">Kode Meja Unik (Cth: M01, M02, M03)</label>
                            <input type="text" name="kode_meja" id="kode_meja" value="{{ old('kode_meja') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @error('kode_meja') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.mejas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>