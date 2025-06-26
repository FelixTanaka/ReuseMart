<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ - Reuse Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light);
      margin: 0;
      padding: 0;
    }

    /* Navbar */
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
    }

    .nav-link:hover, .nav-link.active {
      color: var(--peach) !important;
      font-weight: bold;
    }

    .btn-masuk {
      background-color: var(--peach);
      color: var(--green);
      border-radius: 20px;
      padding: 6px 16px;
      font-weight: 600;
    }

    .btn-daftar {
      border: 1px solid #ddd;
      border-radius: 20px;
      padding: 6px 16px;
      margin-left: 0.5rem;
      background-color: white;
      color: var(--green);
      font-weight: 600;
    }

    .btn-daftar:hover {
      background-color: var(--gray);
    }

    /* FAQ Content */
    .container-faq {
      max-width: 960px;
      margin: 3rem auto;
      background: var(--white);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    h2 {
      color: var(--green);
      margin-bottom: 1rem;
    }

    .faq-box {
      background-color: var(--light);
      padding: 1rem;
      margin-bottom: 0.75rem;
      border-radius: 8px;
      border-left: 4px solid var(--beige);
      font-weight: 500;
    }

    .policy-box {
      background-color: #fff8dc;
      border: 1px solid var(--gray);
      padding: 1rem 1.5rem;
      margin-top: 2rem;
      border-radius: 8px;
    }

    .policy-box h2 {
      margin-bottom: 0.75rem;
      color: var(--dark-green);
    }

    .policy-box p {
      text-align: justify;
      font-size: 0.95rem;
      line-height: 1.6;
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
            <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Produk</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a>
          </li>
        </ul>
      </div>

      <div class="d-flex">
        <a href="{{ route('login') }}" class="btn btn-masuk me-2">Masuk</a>
        <a href="{{ route('register.form') }}" class="btn btn-daftar">Daftar</a>
      </div>
    </div>
  </nav>

  <!-- FAQ Content -->
  <div class="container container-faq">
    <h2 class="text-center mb-4">FAQ (Pertanyaan yang Sering Diajukan)</h2>
    
    <div class="faq-box">1. Apa itu Reuse Mart?</div>
    <div class="faq-box">2. Apakah semua barang di Reuse Mart bekas?</div>
    <div class="faq-box">3. Bagaimana cara melakukan pembelian?</div>
    <div class="faq-box">4. Apakah bisa melakukan pengembalian barang?</div>
    <div class="faq-box">5. Bagaimana cara menjadi penjual di Reuse Mart?</div>

    <div class="policy-box">
      <h2>Kebijakan Privasi</h2>
      <p>
        ReuseMart adalah perusahaan yang bergerak di bidang penjualan barang bekas berkualitas berbasis di Yogyakarta, yang berkomitmen melindungi privasi pengguna dengan mengumpulkan, menggunakan, dan melindungi data secara aman, tidak membagikan informasi kecuali diperlukan untuk transaksi atau diwajibkan oleh hukum, serta memberikan hak kepada pengguna untuk mengakses, mengubah, dan menghapus data pribadi...
      </p>
    </div>

    <div class="policy-box">
      <h2>Syarat Layanan</h2>
      <p>
        Dengan menggunakan layanan ReuseMart, pengguna yang berusia minimal 18 tahun atau memiliki izin orang tua/wali menyetujui bahwa mereka memberikan informasi yang akurat, bertanggung jawab atas keamanan akun, tidak melakukan aktivitas ilegal atau penipuan, mematuhi kebijakan sistem penitipan...
      </p>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; 2025 Reuse Mart. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
