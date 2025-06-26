<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Nota Pengambilan - ReuseMart</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .nota-container {
            max-width: 700px;
            background: white;
            margin: 0 auto;
            padding: 30px 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #4CAF50;
            font-weight: 700;
        }
        .header p {
            margin: 4px 0 0 0;
            font-style: italic;
            color: #666;
        }
        .info-section {
            margin-bottom: 25px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 40px;
        }
        .info-section p {
            margin: 5px 0;
            font-size: 0.95rem;
        }
        .info-section p strong {
            width: 140px;
            display: inline-block;
            color: #555;
        }
        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.95rem;
        }
        table.table th, table.table td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: left;
        }
        table.table th {
            background-color: #4CAF50;
            color: white;
            font-weight: 600;
        }
        table.table tbody tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .signature {
            margin-top: 50px;
            font-size: 0.95rem;
            text-align: left;
            color: #555;
        }
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #333;
            width: 300px;
            padding-top: 5px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .nota-container {
                box-shadow: none;
                border: none;
                max-width: 100%;
                padding: 0;
                margin: 0;
            }
            .header p {
                font-style: normal;
            }
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="header">
            <h2>Nota Pembelian Barang</h2>
            <p>ReuseMart - Gudang</p>
        </div>

        <div class="info-section">
            <p><strong>Nama Pembeli:</strong> {{ $transaksi->pembeli->nama_pembeli }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman ?? '-' }}</p>
            <p><strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</p>
            <p><strong>Jadwal Pengambilan:</strong> {{ $transaksi->jadwal_pengambilan ? \Carbon\Carbon::parse($transaksi->jadwal_pengambilan)->format('d M Y') : '-' }}</p>
            <p><strong>Status Pembelian:</strong> {{ ucfirst($transaksi->status_pembelian) }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $transaksi->barang->nama_barang }}</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>

        <div class="signature">
            <p>Tanda Tangan Pembeli:</p>
            <div class="signature-line"></div>
        </div>
    </div>
</body>
</html>
