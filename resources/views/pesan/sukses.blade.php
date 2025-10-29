<x-guest-layout>
    <div id="status-box" class="bg-white max-w-lg mx-auto text-center p-8 rounded-lg shadow transition-all duration-500">
        <div id="icon-container">
            <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h1 id="status-title" class="text-2xl font-bold mb-2">Pesanan Berhasil Dibuat!</h1>
        <p id="status-message" class="text-gray-600 mb-6">Silakan tunjukkan ID Pesanan di bawah ini ke kasir untuk melakukan pembayaran.</p>

        <div class="bg-gray-100 border-dashed border-2 border-gray-300 rounded-lg p-4">
            <p class="text-gray-500 text-sm">ID PESANAN ANDA</p>
            <p class="text-3xl font-bold tracking-widest">{{ $pesanan->kode_pesanan }}</p>
        </div>

        <div id="download-struk-container" style="display: none;" class="mt-6">
            <a href="{{ route('pesan.struk', $pesanan) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Download Struk (PDF)
            </a>
        </div>
        <p class="text-sm text-gray-500 mt-6">Status: <span id="status-text" class="font-bold text-yellow-500">Menunggu Pembayaran</span></p>
    </div>

    @vite('resources/js/app.js')
    
    {{-- Kita gunakan 'type="module"' agar lebih modern --}}
    <script type="module"> 
        // Pastikan listener berjalan setelah semua DOM siap
        document.addEventListener('DOMContentLoaded', function () {

            // Beri sedikit jeda agar Echo (dari app.js) siap
            setTimeout(() => {
                if (window.Echo) {
                    console.log('Echo siap mendengarkan...');
                    // Mendengarkan di channel yang spesifik untuk pesanan ini
                    window.Echo.channel('pesanan.{{ $pesanan->kode_pesanan }}')
                        .listen('.pesanan-divalidasi', (e) => {
                            console.log('Event diterima!', e);
    
                            // Mengambil elemen-elemen yang akan diubah
                            const iconContainer = document.getElementById('icon-container');
                            const statusTitle = document.getElementById('status-title');
                            const statusMessage = document.getElementById('status-message');
                            const statusText = document.getElementById('status-text');
    
                            // HTML untuk ikon centang hijau
                            const greenCheckIcon = `
                                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>`;
    
                            // Mengubah konten
                            iconContainer.innerHTML = greenCheckIcon;
                            statusTitle.innerText = 'Pembayaran Berhasil!';
                            statusMessage.innerText = 'Pesanan Anda telah dibayar dan sedang kami proses. Mohon tunggu sebentar, kami akan mengantarkannya ke meja Anda.';
                            statusText.innerText = 'Diproses';
    
                            // Mengubah warna
                            statusText.classList.remove('text-yellow-500');
                            statusText.classList.add('text-green-500');

                            // 4. TAMBAHKAN KODE INI UNTUK MEMUNCULKAN TOMBOL
                            const downloadContainer = document.getElementById('download-struk-container');
                            if (downloadContainer) {
                                downloadContainer.style.display = 'block';
                            }
                            // --------------------------------------------

                        });
                } else {
                    console.error('Laravel Echo tidak terinisialisasi.');
                }
            }, 500); // Jeda 500ms
        });
    </script>
</x-guest-layout>