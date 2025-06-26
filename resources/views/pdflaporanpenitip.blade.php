<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PDF Penitipan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        h3, h4, p {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #dee2e6;
        }

        td.text-start {
            text-align: left;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h3>ReUse Mart</h3>
    <p>Jl. Green Eco Park No. 456 Yogyakarta</p>

    <h4>Laporan Barang yang Masa Penitipannya Sudah Habis</h4>
    <p><strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th class="text-start">Nama Produk</th>
                <th>ID Penitip</th>
                <th class="text-start">Nama Penitip</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Akhir</th>
                <th>Batas Ambil</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan_penitipan as $item)
                <tr>
                    <td><strong>{{ strtoupper(substr($item->nama_barang, 0, 1)) }}{{ $item->id_barang }}</strong></td>
                    <td class="text-start">{{ $item->nama_barang }}</td>
                    <td>T{{ $item->id_penitip }}</td>
                    <td class="text-start">{{ $item->nama_penitip }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_penitipan)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->addDays(7)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data penitipan yang masa waktunya habis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh Sistem - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
