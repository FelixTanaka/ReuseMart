<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Per Kategori Barang</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 8px 16px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: white;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #dee2e6;
        }

        .bold {
            font-weight: bold;
        }

        .btn-pdf {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-center mb-4">Owner Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('pegawai.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('pegawai.dashboard', ['halaman' => 'laporan-kategori']) }}">
                        <i class="bi bi-graph-up me-2"></i>Laporan Kategori
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('pegawai.dashboard', ['halaman' => 'laporan-penitipan']) }}">
                        <i class="bi bi-people me-2"></i>Laporan Penitipan</a>
                </li>
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h3 class="mb-2">Laporan Penjualan Per Kategori Barang (Dalam 1 Tahun)</h3>
            <p class="mb-0 fw-bold">ReUse Mart</p>
            <p class="mb-3">Jl. Green Eco Park No. 456 Yogyakarta</p>

            <!-- Tombol Cetak PDF -->
            <a href="{{ route('cetak.laporan.kategori') }}" target="_blank" class="btn btn-danger btn-pdf">
                <i class="bi bi-printer me-1"></i> Cetak PDF
            </a>

            <!-- Tabel Laporan -->
            <!-- Tabel Laporan -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-white">
                    <tr class="text-center">
                        <th style="width: 40%;">Kategori</th>
                        <th style="width: 30%;">Jumlah Item Terjual</th>
                        <th style="width: 30%;">Jumlah Item Gagal Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalTerjual = 0;
                        $totalDonasi = 0;
                    @endphp
                    @foreach ($laporan_kategori as $laporan)
                        @php
                            $totalTerjual += $laporan->jumlah_terjual;
                            $totalDonasi += $laporan->jumlah_didonasikan;
                        @endphp
                        <tr>
                            <td class="text-start">{{ $laporan->nama_kategori }}</td>
                            <td class="text-end">{{ number_format($laporan->jumlah_terjual) }}</td>
                            <td class="text-end">{{ number_format($laporan->jumlah_didonasikan) }}</td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold bg-light text-dark">
                        <td class="text-start">Total</td>
                        <td class="text-end">{{ number_format($totalTerjual) }}</td>
                        <td class="text-end">{{ number_format($totalDonasi) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
