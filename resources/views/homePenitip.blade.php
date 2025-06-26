<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ReuseMart - Barang Titipan</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <style>
    .sidebar {
      height: 100vh;
      background-color: #2f3542;
    }
    .sidebar h2 { color: white; font-size: 1.25rem; font-weight: 600; }
    .sidebar small { color: #7bed9f; font-size: 0.9rem; }
    .sidebar .nav-link {
      color: #dcdde1; font-size: 0.95rem; padding: 8px 15px; border-radius: 5px;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #57606f; color: #ffffff;
    }

    .navbar-custom {
      background-color: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      height: 60px;
    }

    .table th, .table td {
      text-align: center;
      vertical-align: middle;
      font-size: 0.9rem;
    }

    .truncate-text {
      max-width: 180px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    .logout-form { margin-bottom: 0; }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 sidebar py-4">
      <div class="text-center mb-4">
        <h2 class="mb-0">ReuseMart</h2>
        <small class="text-info">Penitip</small>
      </div>
      <ul class="nav flex-column m-0">
        <li class="nav-item mb-1">
          <a href="{{ route('homePenitip') }}" class="nav-link ps-3 pe-2 {{ request()->is('homePenitip') ? 'active fw-bold' : '' }}">
            <i class="fas fa-box me-2"></i> Daftar Barang
          </a>
        </li>
      </ul>
    </nav>

    <!-- Main Content -->
    <div class="col-md-9 ms-sm-auto col-lg-10 px-0">
      <!-- Navbar -->
      <nav class="navbar navbar-expand navbar-custom d-flex justify-content-end pe-4">
        <div class="d-flex justify-content-between align-items-center w-100">
          <h5 class="mb-0 fw-semibold text-dark ms-3">Dashboard Penitip</h5>
          <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
              <i class="fas fa-sign-out-alt me-1"></i> Logout
            </button>
          </form>
        </div>
      </nav>

      <!-- Content -->
      <main class="px-4 mt-4">
        <h2 class="mb-4">Daftar Barang Titipan</h2>

        <!-- Search -->
        <div class="input-group mb-3 w-50">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="text" class="form-control" id="searchInput" placeholder="Cari barang titipan...">
        </div>

        <!-- Table -->
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle barang-table">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Harga Satuan</th>
                <th>Deskripsi</th>
                <th>Tanggal Penitipan</th>
                <th>Tanggal Keluar</th>
                <th>Status Penitipan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($barangTitipan as $barang)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori->nama_kategori }}</td>
                <td>{{ $barang->status }}</td>
                <td>Rp {{ number_format($barang->harga_satuan, 0, ',', '.') }}</td>
                <td class="truncate-text text-start">{{ $barang->deskripsi }}</td>
                <td>{{ $barang->tanggal_penitipan }}</td>
                <td id="tanggal_keluar_{{ $barang->id_barang }}">{{ $barang->tanggal_keluar }}</td>
                <td>{{ $barang->status_penitipan }}</td>
                <td>
                  <form action="{{ route('barang.updateStatus', ['id_barang' => $barang->id_barang]) }}" method="POST" onsubmit="return validateDropdown({{ $barang->id_barang }})">
                    @csrf    
                    @method('PUT')
                    <div class="d-flex gap-2 align-items-center">
                      <select class="form-select form-select-sm" id="status_penitipan_{{ $barang->id_barang }}" name="status_penitipan" onchange="updateTanggalKeluar({{ $barang->id_barang }})">
                        <option value="">-- Pilih --</option>
                        <option value="Diambil">Diambil</option>
                        <option value="Diperpanjang">Diperpanjang</option>
                      </select>
                      <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</div>

<!-- JS: Search, Update Tanggal, Validate -->
<script>
  document.getElementById("searchInput").addEventListener("input", function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll(".barang-table tbody tr");

        rows.forEach(row => {
            let match = false;
            const cells = row.querySelectorAll("td");

            cells.forEach(cell => {
                // Cek apakah ada select di dalam cell
                const select = cell.querySelector("select");
                let text = "";

                if (select) {
                    text = select.options[select.selectedIndex].textContent.toLowerCase();
                } else {
                    text = cell.textContent.toLowerCase();
                }

                // Jika ditemukan keyword
                if (text.includes(keyword)) {
                    match = true;
                }
            });

            // Tampilkan atau sembunyikan baris
            row.style.display = match ? "" : "none";
        });
    });

  function updateTanggalKeluar(id_barang) {
    const select = document.getElementById("status_penitipan_" + id_barang);
    const tanggalKeluarElement = document.getElementById("tanggal_keluar_" + id_barang);

    if (select.value === "Diperpanjang") {
      const currentDate = new Date(tanggalKeluarElement.innerText);
      currentDate.setDate(currentDate.getDate() + 30);
      const newDate = currentDate.toISOString().split('T')[0];
      tanggalKeluarElement.innerText = newDate;
    }
  }

  function validateDropdown(id_barang) {
    const select = document.getElementById("status_penitipan_" + id_barang);
    if (!select.value) {
      Swal.fire({
        icon: 'warning',
        title: 'Pilih Status Penitipan',
        text: 'Silakan pilih status sebelum menyimpan.',
        confirmButtonColor: '#3085d6'
      });
      return false;
    }
    return true;
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
