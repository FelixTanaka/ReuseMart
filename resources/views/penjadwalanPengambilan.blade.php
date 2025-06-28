<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Penjadwalan Pengambilan - ReuseMart</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
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
            font-weight: 700;
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

        .table thead th {
            background-color: #e9ecef;
            text-align: center;
            vertical-align: middle;
        }

        .btn-atur, .btn-cetak-nota {
            font-size: 0.9rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 2rem;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .close {
            float: right;
            font-size: 1.4rem;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-section {
            margin-top: auto;
            padding: 0 1rem 1rem;
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
                    <i class="fas fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <h4 class="mb-4">Jadwal Pengambilan</h4>

        <div class="card shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pembeli</th>
                            <th>Nama Barang</th>
                            <th>Jadwal Pengambilan</th>
                            <th>Nota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi_pembelian as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->pembeli->nama_pembeli }}</td>
                            <td>{{ $data->barang->nama_barang }}</td>
                            <td>{{ $data->jadwal_pengambilan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('cetakNotaPengambilan', $data->id_transaksi_pembelian) }}" target="_blank" class="btn btn-outline-secondary btn-sm btn-cetak-nota">
                                    <i class="fas fa-print"></i> Nota
                                </a>
                            </td>
                            <td>
                                <button
                                    class="btn btn-primary btn-sm btn-atur"
                                    data-id="{{ $data->id_transaksi_pembelian }}"
                                    data-date="{{ $data->jadwal_pengambilan ?? '' }}">
                                    Atur Jadwal
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @if($transaksi_pembelian->isEmpty())
                        <tr>
                            <td colspan="6" class="text-muted">Belum ada data jadwal.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div id="jadwalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="jadwalForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="jadwalInput" class="form-label">Atur Jadwal Pengambilan:</label>
                    <input type="date" name="jadwal_pengambilan" id="jadwalInput" class="form-control" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        document.querySelectorAll('.btn-atur').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const date = button.getAttribute('data-date');
                const form = document.getElementById('jadwalForm');
                const modal = document.getElementById('jadwalModal');
                const input = document.getElementById('jadwalInput');

                form.action = `/jadwal_pengambilan/${id}`;
                input.value = date;
                modal.style.display = 'block';
            });
        });

        function closeModal() {
            document.getElementById('jadwalModal').style.display = 'none';
        }

        window.onclick = function (event) {
            const modal = document.getElementById('jadwalModal');
            if (event.target == modal) {
                closeModal();
            }
        };
    </script>

</body>
</html>
