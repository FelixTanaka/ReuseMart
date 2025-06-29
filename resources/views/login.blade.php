<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>    

    <div class="container">
        <div class="login-wrapper">
            <img src="{{ asset('images/login.png') }}" alt="Login Illustration" class="login-image">
            <div class="login-box">
                <h2>Login</h2>
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <p>
                        Belum Punya Akun?
                        <a href="{{ route('register.form') }}">Daftar</a>
                    </p>
                    
                    <button type="submit" class="btn-login">Login</button>
                </form>
            </div>
        </div>
    </div>


</body>
</html>