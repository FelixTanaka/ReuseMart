<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>History Transaksi - Reuse Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --green: #18230f;
      --dark-green: #27391c;
      --beige: #255f38;
      --peach: #f7d53f;
      --light: #f5f5f5;
      --white: #ffffff;
    }

    body {
      background-color: var(--light);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar {
      background-color: var(--dark-green);
      padding: 0.8rem 1rem;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand strong {
      color: var(--peach);
      font-size: 1.5rem;
    }

    .nav-link {
      font-size: 1rem;
      color: white !important;
      transition: 0.3s;
    }

    .nav-link:hover, .nav-link.active {
      color: var(--peach) !important;
      font-weight: 700;
    }

    .content-section {
      padding: 80px 0 40px;
    }

    .table {
      background-color: var(--white);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .lihat-detail-btn {
      background-color: var(--peach);
      color: var(--dark-green);
      border: none;
      padding: 6px 14px;
      border-radius: 20px;
      font-weight: 600;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1050;
      left: 0; top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
    }

    .modal.open {
      display: block;
    }

    .modal-content {
      background-color: white;
      margin: 10% auto;
      padding: 2rem;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      position: relative;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 1.5rem;
      color: #999;
      cursor: pointer;
    }

    footer {
      background-color: var(--dark-green);
      color: var(--white);
      text-align: center;
      padding: 1rem;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('homePembeli') }}">
        <img src="{{ asset('images/kotak.png') }}" alt="Logo" width="40" class="me-2" />
        <strong>REUSE MART</strong>
      </a>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ route('homePembeli') }}" class="nav-link {{ request()->routeIs('homePembeli') ? 'active' : '' }}">Produk</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('historyTransaksi') }}" class="nav-link {{ request()->routeIs('historyTransaksi') ? 'active' : '' }}">History Transaksi</a>
          </li>
        </ul>
      </div>
      <div class="d-flex">
        <a href="{{ route('profilePembeli') }}" class="btn btn-light me-2 text-success fw-semibold" style="border-radius: 20px; border: 1px solid #ccc;">
          <i class="fas fa-user"></i> Profil
        </a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger fw-semibold" style="border-radius: 20px;">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <section class="content-section">
    <div class="container">
      <h2 class="mb-4">History Transaksi</h2>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>Nama Barang</th>
              <th>Status Pembelian</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transaksi as $index => $item)
            <tr>
              <td>{{ $item->barang->nama_barang }}</td>
              <td>{{ $item->status_pembelian }}</td>
              <td>
                <button class="lihat-detail-btn" onclick="openModal({{ $index }})">Lihat Detail</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Modal Loop -->
  @foreach ($transaksi as $index => $item)
  <div class="modal" id="modal-{{ $index }}">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal({{ $index }})">&times;</span>
      <h4 class="mb-3">Detail Transaksi</h4>
      <p><strong>Nama Pembeli:</strong> {{ $item->pembeli->nama_pembeli }}</p>
      <p><strong>Nama Barang:</strong> {{ $item->barang->nama_barang }}</p>
      <p><strong>Tanggal Transaksi:</strong> {{ $item->tanggal_transaksi }}</p>
      <p><strong>Harga Barang:</strong> Rp{{ number_format($item->harga_barang, 0, ',', '.') }}</p>
      <p><strong>Harga Transaksi:</strong> Rp{{ number_format($item->harga_transaksi, 0, ',', '.') }}</p>
      <p><strong>Harga Ongkir:</strong> Rp{{ number_format($item->harga_ongkir, 0, ',', '.') }}</p>
      <p><strong>Poin Masuk:</strong> {{ $item->poin_masuk }}</p>
      <p><strong>Poin Keluar:</strong> {{ $item->poin_keluar }}</p>
      <p><strong>Poin Pembeli:</strong> {{ $item->poin_pembeli }}</p>
      <p><strong>Status Pembelian:</strong> {{ $item->status_pembelian }}</p>
      <p><strong>Jadwal Pengiriman:</strong> {{ $item->jadwal_pengiriman }}</p>
      <p><strong>Metode Pengiriman:</strong> {{ $item->metode_pengiriman }}</p>
      <p><strong>Status Pengiriman:</strong> {{ $item->status_pengiriman }}</p>
      <p><strong>Jadwal Pengambilan:</strong> {{ $item->jadwal_pengambilan }}</p>
      <p><strong>Alamat Pengiriman:</strong> {{ $item->alamat_pengiriman }}</p>
    </div>
  </div>
  @endforeach

  <!-- Footer -->
  <footer>
    &copy; {{ now()->year }} Reuse Mart. All rights reserved.
  </footer>

  <!-- Scripts -->
  <script>
    function openModal(index) {
      document.getElementById('modal-' + index).classList.add('open');
    }

    function closeModal(index) {
      document.getElementById('modal-' + index).classList.remove('open');
    }

    window.onclick = function(event) {
      document.querySelectorAll('.modal').forEach(modal => {
        if (event.target === modal) {
          modal.classList.remove('open');
        }
      });
    };
  </script>
</body>
</html>
