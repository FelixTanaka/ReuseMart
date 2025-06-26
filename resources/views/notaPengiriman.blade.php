<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pengiriman</title>
    <style>
        body {
            font-family: 'Helvetica Neue', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
            color: #2e2e2e;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .details {
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .details p {
            margin: 6px 0;
            font-size: 15px;
        }

        .label {
            font-weight: 600;
            display: inline-block;
            width: 180px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 14px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f7f7f7;
            font-weight: 600;
            color: #444;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 40px;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Nota Pengiriman</h2>

        <div class="details">
            <p><span class="label">Nama Pembeli:</span> {{ $pengiriman->transaksiPembelian->pembeli->nama_pembeli }}</p>
            <p><span class="label">Nama Barang:</span> {{ $pengiriman->transaksiPembelian->barang->nama_barang }}</p>
            <p><span class="label">Alamat:</span> {{ $pengiriman->transaksiPembelian->alamat_pengiriman }}</p>
            <p><span class="label">Kurir:</span> {{ $pengiriman->pegawai->nama_pegawai ?? '-' }}</p>
            <p><span class="label">Jadwal Pengiriman:</span> {{ $pengiriman->transaksiPembelian->jadwal_pengiriman }}</p>
            <p><span class="label">Metode Pengiriman:</span> {{ $pengiriman->transaksiPembelian->metode_pengiriman }}</p>
            <p><span class="label">Status Pengiriman:</span> {{ $pengiriman->transaksiPembelian->status_pengiriman }}</p>
        </div>

        {{-- Jika ingin menambahkan tabel produk di pengiriman --}}

        <div class="footer">
            &copy; {{ date('Y') }} - Nota ini dicetak secara otomatis oleh sistem.
        </div>
    </div>
</body>
</html>
