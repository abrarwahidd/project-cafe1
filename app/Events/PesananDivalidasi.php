<?php

namespace App\Events;

use App\Models\Pesanan; // Import model Pesanan
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Implement interface ini
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananDivalidasi implements ShouldBroadcast // <-- PENTING
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Instance pesanan yang divalidasi.
     *
     * @var \App\Models\Pesanan
     */
    public $pesanan;

    /**
     * Create a new event instance.
     */
    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Kita akan menyiarkan di channel publik yang namanya unik per pesanan
        return [
            new Channel('pesanan.' . $this->pesanan->kode_pesanan),
        ];
    }

    /**
     * Nama event yang akan disiarkan.
     */
    public function broadcastAs(): string
    {
        return 'pesanan-divalidasi';
    }
}