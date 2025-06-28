<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Gudang ReuseMart</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-size: 14px; /* sedikit diperkecil untuk tabel */
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
        .content {
            margin-left: 250px;
            padding: 1.5rem;
            height: 100vh;
            overflow-y: auto;
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

        /* Tabel Styling */
        .table-responsive {
            overflow-x: auto;
        }
        table.table {
            border-collapse: separate;
            border-spacing: 0 12px;
            width: 100%;
        }
        table.table thead tr th {
            background-color: #e9ecef;
            border: none;
            padding: 14px 15px;
            text-align: center;
            font-weight: 600;
            vertical-align: middle;
            border-radius: 10px 10px 0 0;
            color: #495057;
        }
        table.table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.05);
            border-radius: 10px;
        }
        table.table tbody tr td {
            vertical-align: middle;
            padding: 12px 15px;
            border: none;
        }
        /* Center align kolom No dan Aksi */
        table.table thead tr th:first-child,
        table.table tbody tr td:first-child,
        table.table thead tr th:last-child,
        table.table tbody tr td:last-child {
            text-align: center;
            width: 70px;
        }

        /* Tombol icon kecil */
        .btn-icon {
            padding: 0.3rem 0.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background-color 0.2s, color 0.2s;
        }
        .btn-icon:hover {
            background-color: #0d6efd;
            color: white;
        }
        .btn-outline-danger.btn-icon:hover {
            background-color: #dc3545;
            color: white;
        }

        /* Spasi antar tombol */
        td > form.d-inline, td > a.btn {
            margin-right: 0.4rem;
        }

        /* Badge styling */
        .badge.bg-success {
            background-color: #198754 !important;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .badge.bg-secondary {
            background-color: #6c757d !important;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .badge.bg-warning.text-dark {
            background-color: #ffc107 !important;
            color: #212529 !important;
            font-weight: 600;
            font-size: 0.85rem;
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

        <div class="mt-auto px-3 pb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <header class="mb-4">
            <h1 class="h4 text-secondary">Daftar Barang Penitip</h1>
        </header>

        <div class="card shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
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
                        @foreach ($barang as $index => $item)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $item->penitip->nama_penitip ?? '-' }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->tanggal_penitipan }}</td>
                            <td>{{ $item->tanggal_keluar ?? '-' }}</td>
                            <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status_penitipan == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                                @elseif($item->status_penitipan == 'Keluar')
                                <span class="badge bg-secondary">Keluar</span>
                                @else
                                <span class="badge bg-warning text-dark">{{ $item->status_penitipan }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($barang->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center text-muted">Data tidak ditemukan.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
