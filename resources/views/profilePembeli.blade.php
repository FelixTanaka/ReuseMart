<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Pembeli - Reuse Mart</title>
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

    .profile-section {
      padding: 80px 0;
    }

    .profile-card {
      background-color: white;
      border-radius: 16px;
      padding: 2rem;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
      max-width: 600px;
      margin: auto;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 1rem;
    }

    .edit-button {
      background-color: var(--peach);
      border: none;
      padding: 8px 18px;
      border-radius: 20px;
      font-weight: bold;
      color: #27391c;
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

  <!-- Profil Section -->
  <section class="profile-section">
    <div class="container">
      <div class="profile-card text-center">
        <img src="{{ asset('images/profile.png') }}" alt="Foto Profil" class="profile-img">
        <h3 class="mb-3">{{ $pembeli->nama_pembeli }}</h3>

        <p><strong>Email:</strong> {{ $pembeli->email_pembeli }}</p>
        <p><strong>No. Telepon:</strong> {{ $pembeli->no_telp_pembeli }}</p>
        <p><strong>Poin Reward:</strong> {{ $pembeli->poin_pembeli }}</p>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; {{ now()->year }} Reuse Mart. All rights reserved.
  </footer>

</body>
</html>
