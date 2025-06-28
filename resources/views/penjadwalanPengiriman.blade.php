<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jadwal Pengiriman - ReuseMart</title>

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

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .btn {
            font-size: 0.85rem;
        }

        /* Modal */
        .modal-custom {
            display: none;
            position: fixed;
            z-index: 1055;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content-custom {
            background-color: #fff;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 10px;
            width: 400px;
            position: relative;
        }

        .modal-content-custom .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
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
        <h4 class="mb-4">Jadwal Pengiriman</h4>

        <div class="card shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Pembeli</th>
                            <th>Nama Barang</th>
                            <th>Jadwal</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Alamat</th>
                            <th>Kurir</th>
                            <th>Nota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengiriman->where('transaksiPembelian.metode_pengiriman', 'Dikirim') as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->transaksiPembelian->pembeli->nama_pembeli }}</td>
                            <td>{{ $data->transaksiPembelian->barang->nama_barang }}</td>
                            <td>{{ $data->transaksiPembelian->jadwal_pengiriman }}</td>
                            <td>{{ $data->transaksiPembelian->metode_pengiriman }}</td>
                            <td>{{ $data->transaksiPembelian->status_pengiriman }}</td>
                            <td>{{ $data->transaksiPembelian->alamat_pengiriman }}</td>
                            <td>
                                {{ ($data->pegawai && $data->pegawai->id_role == 5) ? $data->pegawai->nama_pegawai : '-' }}
                            </td>
                            <td>
                                @if($data->pegawai && $data->pegawai->id_role == 5)
                                    <a href="{{ route('pengiriman.cetakNota', $data->id_pengiriman) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-file-pdf"></i> Nota
                                    </a>
                                @else
                                    <span class="text-muted">Belum Ditugaskan</span>
                                @endif
                            </td>
                            <td>
                                @if(!$data->pegawai || $data->pegawai->nama_role != 'kurir')
                                    <button class="btn btn-primary btn-sm pilihKurirBtn" data-id="{{ $data->id_pengiriman }}">
                                        <i class="fas fa-plus"></i> Pilih Kurir
                                    </button>
                                @else
                                    <span class="text-success">Sudah Ditugaskan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($pengiriman->isEmpty())
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data pengiriman.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Pilih Kurir -->
    <div id="modalKurir" class="modal-custom">
        <div class="modal-content-custom">
            <span class="close" onclick="closeModal()">&times;</span>
            <h5 class="mb-3">Pilih Kurir</h5>
            <form id="formKurir" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="id_pegawai" class="form-label">Kurir</label>
                    <select name="id_pegawai" id="id_pegawai" class="form-select" required>
                        <option value="">-- Pilih Kurir --</option>
                        @foreach($listPegawai as $kurir)
                            @if(is_object($kurir) && $kurir->id_role == 5)
                                <option value="{{ $kurir->id_pegawai }}">{{ $kurir->nama_pegawai }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jadwal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                    <input type="date" name="jadwal_pengiriman" id="jadwal_pengiriman" class="form-control" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.querySelectorAll('.pilihKurirBtn').forEach(button => {
            button.addEventListener('click', function () {
                const pengirimanId = this.getAttribute('data-id');
                const form = document.getElementById('formKurir');
                form.setAttribute('action', `{{ url('/pengiriman') }}/${pengirimanId}`);
                document.getElementById('modalKurir').style.display = 'block';
            });
        });

        function closeModal() {
            document.getElementById('modalKurir').style.display = 'none';
        }

        window.onclick = function (event) {
            const modal = document.getElementById('modalKurir');
            if (event.target == modal) {
                closeModal();
            }
        };
    </script>

</body>
</html>
