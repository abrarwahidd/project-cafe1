<?php

namespace App\Events;

use App\Models\Pesanan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananDibuat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    /**
     * Mendefinisikan channel siaran.
     */
    public function broadcastOn(): array
    {
        // Channel publik yang akan didengarkan oleh semua kasir
        return [new Channel('kasir-channel')];
    }

    /**
     * Nama event yang akan disiarkan.
     */
    public function broadcastAs(): string
    {
        return 'pesanan-baru';
    }

    /**
     * Data yang akan dikirim bersama event.
     */
    public function broadcastWith(): array
    {
        // Kita format datanya di sini agar mudah digunakan oleh JavaScript
        return [
            'kode_pesanan' => $this->pesanan->kode_pesanan,
            'nomor_meja' => $this->pesanan->meja->nomor_meja,
            'total_rupiah' => 'Rp ' . number_format($this->pesanan->total_harga, 0, ',', '.'),
            'waktu_pesan' => $this->pesanan->created_at->format('H:i, d M Y'),
            'detail_url' => route('kasir.pesanan.show', $this->pesanan),
        ];
    }
}