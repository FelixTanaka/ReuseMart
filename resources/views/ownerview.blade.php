<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Owner</title>
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
        }

        .sidebar a:hover {
            background-color: #495057;
            display: block;
            padding-left: 10px;
        }

        .content {
            padding: 20px;
        }

        .card-icon {
            font-size: 2rem;
            color: #0d6efd;
        }

        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .card-title {
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
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

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            <h1 class="h3 mb-4">{{ $message ?? 'Selamat datang, Owner!' }}</h1>

            <!-- Statistik Ringkasan -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-box-seam card-icon me-3"></i>
                            <div>
                                <div class="card-title">Total Barang</div>
                                <div class="stat-value">124</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cash-stack card-icon me-3"></i>
                            <div>
                                <div class="card-title">Pendapatan</div>
                                <div class="stat-value">Rp 12.500.000</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card p-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill card-icon me-3"></i>
                            <div>
                                <div class="card-title">Jumlah Pegawai</div>
                                <div class="stat-value">8 Orang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Akun -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person-circle me-2"></i>Informasi Akun</h5>
                    <p class="card-text">Nama: <strong>{{ $pegawai->nama ?? '-' }}</strong></p>
                    <p class="card-text">Email: <strong>{{ $pegawai->email ?? '-' }}</strong></p>
                    <p class="card-text">Role: <strong>Owner</strong></p>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
