<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Transaksi Pembeli - ReuseMart Gudang</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-size: 14px;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #fff;
            border-right: 1px solid #dee2e6;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav-link.active {
            background-color: #cfe2ff;
            color: #0d6efd;
            font-weight: 600;
        }

        .sidebar-header {
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d6efd;
            text-align: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }

        .content {
            margin-left: 250px;
            padding: 1.5rem;
            height: 100vh;
            overflow-y: auto;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table.table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        table.table thead th {
            background-color: #e9ecef;
            border: none;
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle;
            border-radius: 10px 10px 0 0;
        }

        table.table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        table.table tbody td {
            vertical-align: middle;
            padding: 12px 15px;
            border: none;
        }

        .btn-icon {
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            border-radius: 6px;
        }

        .aksi-container {
            display: flex;
            gap: 0.4rem;
            justify-content: center;
        }

        .logout-section {
            margin-top: auto;
            padding: 0 1rem 1rem;
        }

        .logout-section form {
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            ReuseMart <small class="text-muted">Gudang</small>
        </div>
        <nav class="nav flex-column px-3">
            <a href="{{ route('pegawai.dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                Daftar Barang Penitip
            </a>
            <a href="{{ route('pegawai.dashboard', 'pencatatan-barang') }}" class="nav-link {{ request()->is('dashboard/pencatatan-barang') ? 'active' : '' }}">
                Pengambilan Barang
            </a>
            <a href="{{ route('pegawai.dashboard', 'transaksi-pembeli') }}" class="nav-link {{ request()->is('dashboard/transaksi-pembeli') ? 'active' : '' }}">
                Transaksi Pembeli
            </a>
            <a href="{{ route('pegawai.dashboard', 'penjadwalan-pengiriman') }}" class="nav-link {{ request()->is('dashboard/penjadwalan-pengiriman') ? 'active' : '' }}">
                Penjadwalan Pengiriman
            </a>
            <a href="{{ route('pegawai.dashboard', 'penjadwalan-pengambilan') }}" class="nav-link {{ request()->is('dashboard/penjadwalan-pengambilan') ? 'active' : '' }}">
                Jadwal Pengambilan
            </a>
            <a href="{{ route('pegawai.dashboard', 'transaksi-diambil') }}" class="nav-link {{ request()->is('dashboard/transaksi-diambil') ? 'active' : '' }}">
                Transaksi Diambil
            </a>
        </nav>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <header class="mb-4">
            <h4 class="text-secondary">Daftar Transaksi Pembeli</h4>
        </header>

        <div class="card shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pembeli</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Transaksi</th>
                            <th>Harga Barang</th>
                            <th>Total Harga</th>
                            <th>Harga Ongkir</th>
                            <th>Status</th>
                            <th>Jadwal</th>
                            <th>Metode</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi_pembelian as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaksi->pembeli->nama_pembeli }}</td>
                            <td>{{ $transaksi->barang->nama_barang }}</td>
                            <td>{{ $transaksi->tanggal_transaksi }}</td>
                            <td>Rp {{ number_format($transaksi->harga_barang, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->total_harga_transaksi, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->harga_ongkir, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->status_pembelian }}</td>
                            <td>{{ $transaksi->jadwal_pengiriman }}</td>
                            <td>{{ $transaksi->metode_pengiriman }}</td>
                            <td>{{ $transaksi->alamat_pengiriman }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">Belum ada transaksi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
