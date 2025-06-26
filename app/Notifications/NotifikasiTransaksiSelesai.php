<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiTransaksiSelesai extends Notification
{
    use Queueable;

    public $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function via($notifiable)
    {
        return ['database', 'firebase']; // firebase jika pakai FirebaseService
    }

    public function toArray($notifiable)
    {
        return [
            'judul' => 'Transaksi Selesai',
            'pesan' => 'Transaksi #' . $this->transaksi->id_transaksi_pembelian . ' telah selesai.',
        ];
    }
}
