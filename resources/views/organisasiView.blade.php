<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Organisasi</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }

    .sidebar {
      width: 250px;
      background-color: #1f2937;
      padding: 25px 20px;
      color: #fff;
      height: 100vh;
    }

    .sidebar .sidebar-header {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
      color: #e2e8f0;
    }

    .sidebar .nav-link {
      color: #cbd5e1;
      font-size: 16px;
      font-weight: 500;
      padding: 10px 15px;
      transition: all 0.3s ease;
      border-radius: 8px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #374151;
      color: #fff;
    }

    .sidebar .nav-link i {
      margin-right: 12px;
      font-size: 18px;
    }

    .navbar-custom {
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .main-content {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .content-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .modal.fade .modal-dialog {
      transform: translateY(-100px);
      transition: transform 0.3s ease-out;
    }
    .modal.show .modal-dialog {
      transform: translateY(0);
    }

  </style>
</head>
<body>
  <div class="d-flex min-vh-100">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-header">
        <i class="bi bi-building me-2"></i>Organisasi
      </div>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a class="nav-link active" href="#">
            <i class="bi bi-gift"></i> Request Donasi
          </a>
        </li>
      </ul>
    </div>

    <!-- Content Area -->
    <div class="content-wrapper">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-custom px-4 py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          <span class="navbar-brand fw-semibold text-dark">
            <i class="bi bi-globe2 me-2"></i>Sistem Organisasi
          </span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </div>
      </nav>
      
      <!-- Main Content -->
      <main class="flex-grow-1 px-4 py-4">
        <div class="main-content">
          <h2 class="mb-3 fw-semibold">Halo, {{ $organisasi->nama_organisasi }}</h2>
          <p class="text-secondary mb-4">Berikut adalah daftar request donasi dari organisasi Anda:</p>

          <div class="mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRequestModal">
              <i class="bi bi-plus-circle me-1"></i> Tambah Request Donasi
            </button>
          </div>


          <!-- Modal Tambah Request Donasi -->
        <div class="modal fade" id="tambahRequestModal" tabindex="-1" aria-labelledby="tambahRequestModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- modal-lg agar lebar -->
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tambahRequestModalLabel">Tambah Request Donasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <form action="{{ route('request.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="deskripsi_request" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_request" class="form-control" id="deskripsi_request" required></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="tanggal_request" class="form-label">Tanggal Request</label>
                    <input type="date" name="tanggal_request" class="form-control" id="tanggal_request" required>
                  </div>
                  <input type="hidden" name="id_organisasi" value="{{ $organisasi->id_organisasi }}">
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Kirim</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>

          <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari deskripsi atau status...">
          </div>

          <div class="table-responsive">
            <table class="table table-bordered align-middle" id="requestTable">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Deskripsi</th>
                  <th>Status</th>
                  <th>Tanggal Request</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($requests as $index => $req)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $req->deskripsi_request }}</td>
                    <td>
                      <span class="badge
                        {{ $req->status_request === 'Diproses' ? 'bg-warning' :
                           ($req->status_request === 'Disetujui' ? 'bg-success' : 'bg-danger') }}">
                        {{ ucfirst($req->status_request) }}
                      </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($req->tanggal_request)->format('d M Y') }}</td>
                    <td>
                      <!-- Tombol Edit -->
                      <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editRequestModal{{ $req->id_request }}">
                        <i class="bi bi-pencil-square"></i>
                      </button>

                      <!-- Modal Edit Request Donasi -->
                      <div class="modal fade" id="editRequestModal{{ $req->id_request }}" tabindex="-1" aria-labelledby="editRequestModalLabel{{ $req->id_request }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="editRequestModalLabel{{ $req->id_request }}">Edit Request Donasi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <form action="{{ route('request.update', $req->id_request) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-body">
                                <div class="mb-3">
                                  <label for="deskripsi_request{{ $req->id_request }}" class="form-label">Deskripsi</label>
                                  <textarea name="deskripsi_request" class="form-control" id="deskripsi_request{{ $req->id_request }}" required>{{ $req->deskripsi_request }}</textarea>
                                </div>
                                <div class="mb-3">
                                  <label for="tanggal_request{{ $req->id_request }}" class="form-label">Tanggal Request</label>
                                  <input type="date" name="tanggal_request" class="form-control" id="tanggal_request{{ $req->id_request }}" value="{{ $req->tanggal_request }}" required>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>


                      <!-- Tombol Hapus -->
                      <form action="{{ route('request.destroy', $req->id_request) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus request ini?')">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada request donasi.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
      const input = this.value.toLowerCase();
      const rows = document.querySelectorAll("#requestTable tbody tr");

      rows.forEach(row => {
        const deskripsi = row.children[1].textContent.toLowerCase();
        const status = row.children[2].textContent.toLowerCase();
        const tanggal = row.children[3].textContent.toLowerCase();

        if (deskripsi.includes(input) || status.includes(input) || tanggal.includes(input)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
