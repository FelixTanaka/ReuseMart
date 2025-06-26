<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reuse Mart - Halaman Pembeli</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <style>
    :root {
      --green: #18230f;
      --dark-green: #27391c;
      --beige: #255f38;
      --peach: #f7d53f;
      --light: #f5f5f5;
      --white: #ffffff;
      --gray: #cccccc;
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

    .product-card {
      background-color: var(--white);
      border-radius: 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      overflow: hidden;
      transition: 0.3s;
      cursor: pointer;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .product-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .card-body {
      padding: 1rem;
    }

    .card-title {
      font-weight: bold;
      font-size: 1.1rem;
    }

    .card-price {
      color: var(--beige);
      font-weight: bold;
    }

    .badge-status {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 0.8rem;
      padding: 0.3rem 0.6rem;
      border-radius: 10px;
      font-weight: 600;
    }

    .badge-status.Tersedia {
      background-color: #28a745;
      color: white;
    }

    .badge-status.Terjual {
      background-color: #dc3545;
      color: white;
    }

    footer {
      background-color: var(--dark-green);
      color: var(--white);
      text-align: center;
      padding: 1rem;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center text-white" href="#">
        <img src="{{ asset('images/kotak.png') }}" alt="Logo" width="40" class="me-2" />
        <strong>REUSE MART</strong>
      </a>
      <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

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

  <!-- Produk -->
  <section class="py-5">
    <div class="container">
      <h2 class="mb-4">Daftar Produk</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($barang as $item)
        <div class="col">
          <div class="card product-card position-relative h-100"
               onclick="openModal('{{ asset($item->gambar) }}', '{{ $item->nama_barang }}', '{{ number_format($item->harga_satuan, 0, ',', '.') }}', '{{ $item->deskripsi }}', '{{ $item->status }}')"
               data-bs-toggle="modal" data-bs-target="#productModal">
            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_barang }}" class="product-image">
            <div class="card-body">
              <h5 class="card-title">{{ $item->nama_barang }}</h5>
              <p class="card-price">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
            </div>
            <span class="badge badge-status {{ $item->status }}">{{ $item->status }}</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-name">Nama Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modal-image" src="" class="img-fluid rounded mb-4" style="max-height: 300px; object-fit: contain;" />
          <p><strong>Harga:</strong> <span id="modal-price-value"></span></p>
          <p><strong>Deskripsi:</strong> <span id="modal-description-value"></span></p>
          <p><strong>Status:</strong> <span id="modal-status-value"></span></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2025 Reuse Mart. All rights reserved.
  </footer>

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openModal(imageSrc, name, price, description, status) {
      document.getElementById('modal-image').src = imageSrc;
      document.getElementById('modal-name').innerText = name;
      document.getElementById('modal-price-value').innerText = 'Rp ' + price;
      document.getElementById('modal-description-value').innerText = description;
      document.getElementById('modal-status-value').innerText = status;
    }
  </script>
</body>
</html>
