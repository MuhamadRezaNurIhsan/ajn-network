<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Reset Password - AJ NETWORK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk icon mata standar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            transition: background 0.3s ease;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        body.dark-mode {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        body.light-mode {
            background: linear-gradient(135deg, #F5F6F5 0%, #E8ECF1 100%);
        }
        
        body.light-mode .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode .brand h1 {
            background: linear-gradient(135deg, #0B326D, #1a4a8a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        body.light-mode .form-group label {
            color: #475569;
        }
        
        body.light-mode .form-group input {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
            color: #1E293B;
        }
        
        body.light-mode .form-group input:focus {
            border-color: #0B326D;
        }
        
        body.light-mode .btn-login {
            background: linear-gradient(135deg, #0B326D, #1a4a8a);
        }
        
        body.light-mode .btn-login:hover {
            background: linear-gradient(135deg, #1a4a8a, #0B326D);
            box-shadow: 0 8px 20px rgba(11, 50, 109, 0.3);
        }
        
        body.light-mode .footer {
            color: #94A3B8;
        }
        
        .login-card {
            max-width: 420px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 40px 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 16px;
        }
        .logo img {
            width: 80px;
            height: auto;
            margin: 0 auto;
        }
        
        .brand {
            text-align: center;
            margin-bottom: 32px;
        }
        .brand h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #F39C16, #F0D192);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 6px;
        }
        .brand p {
            font-size: 12px;
            color: #94A3B8;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #94A3B8;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            color: #F1F5F9;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #F39C16;
            background: rgba(255, 255, 255, 0.08);
        }
        .form-group input::placeholder {
            color: #64748B;
        }

        .form-group select{
            width:100%;
            padding:12px 16px;
            background:rgba(255,255,255,.05);
            border:1px solid rgba(255,255,255,.1);
            border-radius:14px;
            color:#F1F5F9;
            font-size:14px;
        }

        .form-group select option{
            background:#1E293B;
            color:#F8FAFC;
        }

        .form-group select:focus{
            outline:none;
            border-color:#F39C16;
        }

        body.light-mode .form-group select{
            background:rgba(0,0,0,.05);
            color:#1E293B;
            border-color:rgba(0,0,0,.1);
        }
        
        /* Password wrapper dengan icon mata */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 45px;
        }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94A3B8;
            font-size: 18px;
            transition: color 0.2s ease;
        }
        .toggle-password:hover {
            color: #F39C16;
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #F39C16, #E67E22);
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(243, 156, 22, 0.3);
            background: linear-gradient(135deg, #E67E22, #F39C16);
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 10px 16px;
            margin-bottom: 20px;
            color: #F87171;
            font-size: 12px;
            text-align: center;
        }

        .alert-success{
            background:rgba(34,197,94,.15);
            border:1px solid rgba(34,197,94,.3);
            border-radius:12px;
            padding:10px 16px;
            margin-bottom:20px;
            color:#4ADE80;
            font-size:12px;
            text-align:center;
        }
        
        .footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: #64748B;
        }
    </style>
</head>
<body id="appBody" class="dark-mode">
    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('images/logo_ajn.png') }}" alt="Logo AJ NETWORK">
        </div>
        
        <div class="brand">
            <h1>AJ NETWORK</h1>
            <p>Sistem Monitoring Jaringan</p>
        </div>
        
        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif
        
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
            @endif
        <form method="POST" action="{{ route('password.reset') }}">
            
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="admin" autocomplete="off" required>
            </div>
            <div class="form-group">

            <label>Nama Lengkap</label>

            <input
                type="text"
                name="nama_lengkap"
                value="{{ old('nama_lengkap') }}"
                placeholder="Nama Lengkap"
                autocomplete="off"
                required>

            </div>
            <div class="form-group">

            <label>Role</label>

            <select name="role" required>

                <option value=""selected disabled hidden>
                    Pilih Role
                </option>

                <option value="administrator"
                    {{ old('role') == 'administrator' ? 'selected' : '' }}>
                    Administrator
                </option>

                <option value="direktur"
                    {{ old('role') == 'direktur' ? 'selected' : '' }}>
                    Direktur
                </option>

            </select>

            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                    <i class="toggle-password fas fa-eye" onclick="togglePassword()"></i>
                </div>
            </div>
            <div id="passwordStrength"
                style="font-size:12px;margin-top:-10px; margin-bottom:15px;">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <div class="password-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required> 
                    <i class="toggle-password fas fa-eye" onclick="toggleConfirmPassword()"></i>
                </div>
            </div>
            <div id="passwordMatch" style="font-size:12px; margin-top:-10px; margin-bottom:15px;"> </div>
            <button type="submit" class="btn-login">
                Reset Password
            </button>
            <div style="text-align:center;margin-top:18px;">

                <a href="{{ route('login') }}"
                style="
                color:#F39C16;
                text-decoration:none;
                font-size:13px;">

                    Kembali ke Login

                </a>

            </div>
        </form>
        
        <div class="footer">
            <p>PT. AJ NETWORK NET FIBER © {{ date('Y') }}</p>
        </div>
    </div>

    <script>
       function applyTheme() {
            let theme = sessionStorage.getItem('theme') || 'dark';
            document.body.classList.remove('dark-mode', 'light-mode');
            document.body.classList.add(theme === 'dark' ? 'dark-mode' : 'light-mode');
        }
        applyTheme();
        
        // ===== TOGGLE PASSWORD =====
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function toggleConfirmPassword() {

            const passwordInput = document.getElementById('password_confirmation');
            const toggleIcon = document.querySelectorAll('.toggle-password')[1];

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }

        }

        const password = document.getElementById('password');
        const strength = document.getElementById('passwordStrength');

        password.addEventListener('keyup', function () {

            let score = 0;

            if (this.value.length >= 8) score++;
            if (/[A-Z]/.test(this.value)) score++;
            if (/[a-z]/.test(this.value)) score++;
            if (/[0-9]/.test(this.value)) score++;

            if (score <= 2) {

                strength.innerHTML = "🔴 Password Lemah";

            } else if (score == 3) {

                strength.innerHTML = "🟡 Password Sedang";

            } else {

                strength.innerHTML = "🟢 Password Kuat";

            }

        });

        const confirmPassword =
        document.getElementById('password_confirmation');

        const match =
        document.getElementById('passwordMatch');

        confirmPassword.addEventListener('keyup', function () {

            if (password.value == confirmPassword.value) {

                match.innerHTML =
                "Password cocok";

                match.style.color = "#22C55E";

            } else {

                match.innerHTML =
                "Password tidak sama";

                match.style.color = "#EF4444";

            }

        });

        document.querySelector('form').addEventListener('submit', function () {

            const btn = document.querySelector('.btn-login');

            btn.innerHTML = "Memproses...";

            btn.disabled = true;

        });
    </script>
</body>
</html>