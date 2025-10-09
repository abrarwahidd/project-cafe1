<x-guest-layout>
    <div x-data="menuSystem()" x-init="init()">
        <h1 class="text-2xl font-bold mb-4">Pemesanan Meja No: {{ $meja->nomor_meja }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                @foreach ($menus as $kategori => $items)
                    <h2 class="text-xl font-semibold mt-6 mb-2 capitalize">{{ $kategori }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($items as $menu)
                            <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                                <img src="{{ $menu->gambar ? Storage::url($menu->gambar) : 'https://via.placeholder.com/150' }}" alt="{{ $menu->nama }}" class="w-full h-32 object-cover rounded-md mb-4">
                                <h3 class="font-bold text-lg flex-grow">{{ $menu->nama }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $menu->deskripsi }}</p>
                                <div class="flex justify-between items-center mt-auto">
                                    <span class="font-semibold text-blue-600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    <button @click="addToCart({{ json_encode($menu) }})" class="bg-blue-500 text-white px-3 py-1 text-sm rounded hover:bg-blue-600">
                                        + Tambah
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-4 sticky top-4">
                    <h2 class="text-xl font-bold border-b pb-2 mb-4">Keranjang Anda</h2>
                    <template x-if="cart.length === 0">
                        <p class="text-gray-500">Keranjang masih kosong.</p>
                    </template>
                    <div class="space-y-2">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold" x-text="item.nama"></p>
                                    <p class="text-sm text-gray-500" x-text="'Rp ' + formatRupiah(item.harga)"></p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="updateQuantity(item.id, -1)" class="text-red-500">-</button>
                                    <span x-text="item.jumlah"></span>
                                    <button @click="updateQuantity(item.id, 1)" class="text-green-500">+</button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <template x-if="cart.length > 0">
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total:</span>
                                <span x-text="'Rp ' + formatRupiah(total)"></span>
                            </div>
                            <button @click="submitOrder()" :disabled="isSubmitting" class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded mt-4 hover:bg-green-600 disabled:bg-gray-400">
                                <span x-show="!isSubmitting">Pesan Sekarang</span>
                                <span x-show="isSubmitting">Memproses...</span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
        function menuSystem() {
            return {
                cart: [],
                isSubmitting: false,
                init() {
                    const savedCart = localStorage.getItem('cart_{{ $meja->id }}');
                    if (savedCart) {
                        this.cart = JSON.parse(savedCart);
                    }
                },
                get total() {
                    return this.cart.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
                },
                addToCart(menu) {
                    const existingItem = this.cart.find(item => item.id === menu.id);
                    if (existingItem) {
                        existingItem.jumlah++;
                    } else {
                        this.cart.push({ ...menu, jumlah: 1 });
                    }
                    this.saveCart();
                },
                updateQuantity(id, amount) {
                    const item = this.cart.find(item => item.id === id);
                    if (item) {
                        item.jumlah += amount;
                        if (item.jumlah <= 0) {
                            this.cart = this.cart.filter(cartItem => cartItem.id !== id);
                        }
                    }
                    this.saveCart();
                },
                saveCart() {
                    localStorage.setItem('cart_{{ $meja->id }}', JSON.stringify(this.cart));
                },
                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                },
                submitOrder() {
                    this.isSubmitting = true;
                    fetch('{{ route('pesan.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id_meja: '{{ $meja->id }}',
                            cart: JSON.stringify(this.cart)
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.redirect_url) {
                            localStorage.removeItem('cart_{{ $meja->id }}');
                            window.location.href = data.redirect_url;
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        this.isSubmitting = false;
                    });
                }
            }
        }
    </script>
</x-guest-layout>