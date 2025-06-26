<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan per Kategori Barang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h2, h3, p {
            margin: 4px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>ReUse Mart</h2>
    <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
    <h3>Laporan Penjualan Per Kategori Barang</h3>
    <p>Tahun: {{ date('Y') }}</p>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>


    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah Item Terjual</th>
                <th>Jumlah Item Gagal Terjual</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTerjual = 0;
                $totalDonasi = 0;
            @endphp
            @foreach ($laporan_kategori as $item)
                @php
                    $totalTerjual += $item->jumlah_terjual;
                    $totalDonasi += $item->jumlah_didonasikan;
                @endphp
                <tr>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->jumlah_terjual }}</td>
                    <td>{{ $item->jumlah_didonasikan }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ $totalTerjual }}</td>
                <td>{{ $totalDonasi }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
