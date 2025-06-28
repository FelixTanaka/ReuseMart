<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pencatatan Pengambilan Barang - ReuseMart Gudang</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-color: #f8f9fa;
            font-size: 14px;
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
            border-radius: 10px;
        }

        table.table tbody td {
            vertical-align: middle;
            padding: 12px 15px;
            border: none;
        }

        table.table td:first-child,
        table.table td:last-child,
        table.table th:first-child,
        table.table th:last-child {
            text-align: center;
            width: 60px;
        }

        .badge-status {
            font-size: 0.85rem;
            font-weight: 600;
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
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'pencatatan-barang']) }}" class="nav-link {{ request()->is('dashboard/pencatatan-barang') ? 'active' : '' }}">
                Pengambilan Barang
            </a>
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'transaksi-pembeli']) }}" class="nav-link {{ request()->is('dashboard/transaksi-pembeli') ? 'active' : '' }}">
                Transaksi Pembeli
            </a>
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'penjadwalan-pengiriman']) }}" class="nav-link {{ request()->is('dashboard/penjadwalan-pengiriman') ? 'active' : '' }}">
                Penjadwalan Pengiriman
            </a>
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'penjadwalan-pengambilan']) }}" class="nav-link {{ request()->is('dashboard/penjadwalan-pengambilan') ? 'active' : '' }}">
                Jadwal Pengambilan
            </a>
            <a href="{{ route('pegawai.dashboard', ['halaman' => 'transaksi-diambil']) }}" class="nav-link {{ request()->is('dashboard/transaksi-diambil') ? 'active' : '' }}">
                Transaksi Diambil
            </a>
        </nav>


        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
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
            <h4 class="text-secondary">Daftar Pengambilan Barang Penitip</h4>
        </header>

        <div class="card shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Penitip</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Tanggal Penitipan</th>
                            <th>Tanggal Keluar</th>
                            <th>Harga Satuan</th>
                            <th>Status Penitipan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barang as $index => $item)
                            @if($item->status_penitipan === 'Diambil')
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->penitip->nama_penitip ?? '-' }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                <td>{{ $item->tanggal_penitipan }}</td>
                                <td>{{ $item->tanggal_keluar ?? '-' }}</td>
                                <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-secondary badge-status">{{ $item->status_penitipan }}</span>
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td>
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
