<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Transaksi Siap Dikirim - ReuseMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        body {
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
        .sidebar-header {
            font-weight: bold;
            font-size: 1.5rem;
            color: #0d6efd;
            text-align: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
        .nav-link.active {
            background-color: #cfe2ff;
            color: #0d6efd;
            font-weight: 600;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
        }
        .logout-section {
            margin-top: auto;
            padding: 0 1rem 1rem;
        }
        .btn-sm {
            font-size: 0.75rem;
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
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <h4 class="mb-4">Daftar Transaksi Siap Diambil</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Pembeli</th>
                                <th>Alamat Pengiriman</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi as $t)
                                @if ($t->metode_pengiriman == 'Diambil')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $t->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $t->pembeli->nama_pembeli ?? '-' }}</td>
                                    <td>{{ $t->alamat_pengiriman }}</td>
                                    <td>{{ $t->status_pembelian }}</td>
                                    <td>
                                        <!-- Kirim Notifikasi -->
                                        <form method="POST" action="{{ route('notifikasi.kirimTransaksi', $t->id_transaksi_pembelian) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Kirim notifikasi ke pembeli?')">
                                                <i class="fas fa-bell"></i> Notifikasi
                                            </button>
                                        </form>

                                        <!-- Selesaikan -->
                                        <form method="POST" action="{{ route('transaksiPembelian.selesai', $t->id_transaksi_pembelian) }}" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin menyelesaikan transaksi ini?')">
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada transaksi untuk metode pengambilan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
