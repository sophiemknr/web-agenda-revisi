<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="{{ asset('css/style_login.css') }}" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="">
        <div class="container" id="container">
            <div class="form-container sign-in">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <h1>Agenda Bapak</h1>
                    @if ($errors->any())
                        <div class="error-message" style="color: red; margin-bottom: 10px;">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <input type="text" name="username" placeholder="Username" required>
                    <div class="password-container">
                        <input type="password" name="password" id="password" placeholder="Kata Sandi" required>
                        <span class="toggle-password">
                            <ion-icon name="eye-off" id="eye-icon"></ion-icon>
                        </span>
                    </div>
                    <button type="submit">Masuk</button>
                </form>
            </div>
            <div class="toggle-container">
                <div class="toggle">
                    <span class="icon">
                        <img src="{{ asset('images/LOGO_FIX.png') }}" alt="Logo Kota Bogor" width="300">
                    </span>
                    <div class="toggle-panel toggle-left">
                        <h1>Selamat Datang Kembali!</h1>

                        <button class="hidden" id="login">Masuk</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
    </div>
    </div>
</body>

</html>
