<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    @if(session('success'))
        <script>
            Swal.fire({
                title: "Registrasi Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK",
                backdrop: 'rgba(0,0,0,0.5)'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.body.style.filter = "none";
                    window.location.href = "{{ route('login') }}";
                }
            });
        </script>
    @endif


    <div class="container">
        <div class="login-wrapper">
            <img src="{{ asset('images/register.png') }}" alt="Login Illustration" class="login-image">
            <div class="login-box">
                <h2>Register</h2>
                <form  id="registerForm" action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="role">Daftar Sebagai</label>
                        <select id="role" name="nama_role" required onchange="toggleFields()">
                            <option value="pembeli">Pembeli</option>
                            <option value="organisasi">Organisasi</option>
                        </select>
                    </div>

                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-group hidden" id="alamat-field">
                        <label for="alamat_organisasi">Alamat Organisasi</label>
                        <input type="text" id="alamat_organisasi" name="alamat_organisasi" placeholder="Masukkan alamat organisasi">
                    </div>

                    <div class="form-group hidden" id="foto-field">
                        <label for="foto_organisasi">Upload Logo Organisasi</label>
                        <input type="file" id="foto_organisasi" name="foto_organisasi" accept="image/*">
                    </div>
                    <p>
                        Sudah Punya Akun?
                        <a href="{{ route('login') }}">Masuk</a>
                    </p>
                    
                    <button type="submit" class="btn-login">Daftar</button>
                </form>
        </div>
    </div>
    
    <script>
        function toggleFields() {
            var role = document.getElementById("role").value;
            var alamatField = document.getElementById("alamat-field");
            var fotoField = document.getElementById("foto-field");

            var alamatInput = document.getElementById("alamat_organisasi");
            var fotoInput = document.getElementById("foto_organisasi");

            if (role === "organisasi") {
                alamatField.classList.remove("hidden");
                fotoField.classList.remove("hidden");
                alamatInput.setAttribute("required", "required");
            } else {
                alamatField.classList.add("hidden");
                fotoField.classList.add("hidden");
                alamatInput.removeAttribute("required");
                fotoInput.removeAttribute("required");
            }
        }
    </script>


</body>
</html>