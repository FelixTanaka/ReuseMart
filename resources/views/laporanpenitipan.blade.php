<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penitipan Barang</title>

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

        .btn-pdf {
            margin-bottom: 20px;
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
                        <i class="bi bi-people me-2"></i>Laporan Penitipan
                    </a>
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

        <!-- Konten -->
        <div class="col-md-9 col-lg-10 content">
            <h3 class="mb-2">ReUse Mart</h3>
            <p>Jl. Green Eco Park No. 456 Yogyakarta</p>
            <h4 class="mt-4 mb-2">LAPORAN Barang yang Masa Penitipannya Sudah Habis</h4>
            <p><strong>Tanggal cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

            <a href="{{ route('pegawai.laporan-penitipan.pdf') }}" target="_blank" class="btn btn-danger mb-3">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </a>

            <!-- Input Search -->
            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari berdasarkan Kode, Nama, ID, Tanggal...">

            <div class="card shadow-sm rounded p-3 bg-white">
                <h5 class="mb-3">Daftar Barang yang Masa Penitipannya Habis</h5>

                <table class="table table-bordered table-striped table-hover align-middle text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Kode Produk</th>
                            <th scope="col" class="text-start">Nama Produk</th>
                            <th scope="col">ID Penitip</th>
                            <th scope="col" class="text-start">Nama Penitip</th>
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Tanggal Akhir</th>
                            <th scope="col">Batas Ambil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan_penitipan as $item)
                            <tr>
                                <td><strong>{{ strtoupper(substr($item->nama_barang, 0, 1)) }}{{ $item->id_barang }}</strong></td>
                                <td class="text-start">{{ $item->nama_barang }}</td>
                                <td>T{{ $item->id_penitip }}</td>
                                <td class="text-start">{{ $item->nama_penitip }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_penitipan)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_keluar)->addDays(7)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Search -->
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            row.style.display = rowText.includes(query) ? '' : 'none';
        });
    });
</script>

</body>
</html>
