<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifikasiUntukPenitip extends Notification
{
    use Queueable;

    public $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function via($notifiable)
    {
        return ['database', 'firebase'];
    }

    public function toArray($notifiable)
    {
        return [
            'judul' => 'Barangmu Telah Terjual!',
            'pesan' => 'Barang pada transaksi #' . $this->transaksi->id_transaksi_pembelian . ' telah selesai diproses dan dikonfirmasi.',
        ];
    }
}
