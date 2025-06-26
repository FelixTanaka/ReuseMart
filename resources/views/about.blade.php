<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tentang Kami - Reuse Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
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
    }

    .navbar {
      background-color: var(--dark-green);
      padding: 0.8rem 1rem;
    }

    .navbar-brand strong {
      color: var(--peach);
      font-size: 1.5rem;
    }

    .nav-link {
      font-size: 1rem;
      color: white !important;
    }

    .nav-link.active,
    .nav-link:hover {
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

    .about-section {
      padding: 4rem 1rem;
    }

    .about-box {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.05);
      padding: 2rem;
      max-width: 1100px;
      margin: 0 auto;
    }

    .about-section h2 {
      color: var(--green);
      font-weight: bold;
      margin-bottom: 1.5rem;
    }

    .about-section p {
      font-size: 1rem;
      color: #333;
      line-height: 1.7;
      text-align: justify;
    }

    .about-image {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      margin-top: 1.5rem;
    }

    footer {
      background-color: var(--dark-green);
      color: var(--white);
      text-align: center;
      padding: 1rem;
      margin-top: 4rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
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

  <!-- About Section -->
  <section class="about-section">
    <div class="about-box">
      <h2 class="text-center">Apa Itu Reuse Mart?</h2>
      <p>
        ReuseMart adalah perusahaan yang bergerak di bidang penjualan barang bekas berkualitas yang berbasis di Yogyakarta. Didirikan oleh Pak Raka Pratama, seorang pengusaha muda yang memiliki kepedulian tinggi terhadap isu lingkungan, pengelolaan limbah, dan konsep ekonomi sirkular.
      </p>
      <p>
        Dengan visi untuk mengurangi penumpukan sampah dan memberikan kesempatan kedua bagi barang-barang bekas yang masih layak pakai, ReuseMart hadir sebagai solusi inovatif yang memadukan nilai sosial dan bisnis.
      </p>
      <p>
        ReuseMart memfasilitasi masyarakat untuk menjual dan membeli barang bekas berkualitas, dengan aneka kategori baik elektronik maupun non-elektronik — mulai dari kulkas, TV, oven, meja makan, rak buku, pakaian, buku, sepatu, dan lain-lain.
      </p>
      <p>
        Platform ini juga menjadi jembatan bagi mereka yang ingin mendapatkan barang berkualitas dengan harga terjangkau, sekaligus berkontribusi dalam upaya pengurangan limbah dan menjaga kelestarian lingkungan.
      </p>
      <img src="{{ asset('images/gambar1.png') }}" alt="Gambar Tentang Kami" class="about-image mx-auto d-block" />
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; 2025 Reuse Mart. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
