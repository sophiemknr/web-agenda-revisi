@extends('layouts.app', ['pageTitle' => 'User'])

@section('title', 'Manajemen User')

@section('content')
    <h2 class="user-header">User</h2>
    <section class="content mt-4">
        <div class="container-fluid">
            <div
                class="user-main-box bg-white p-4 rounded-3 shadow-sm d-flex flex-row flex-wrap gap-4 user-form-table-responsive align-items-start">
                <div class="user-form-col flex-grow-1 flex-basis-0" style="min-width:240px;">
                    <form method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" class="user-input" name="name" value="{{ $user->name ?? old('name') }}"
                                required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Username</label>
                            <input type="text" class="user-input" name="username"
                                value="{{ $user->username ?? old('username') }}" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="user-input" name="email"
                                value="{{ $user->email ?? old('email') }}" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="user-input-group">
                                <input type="password" class="user-input input" name="password" id="password-hints"
                                    placeholder="*isi jika ingin diubah" autocomplete="off" aria-autocomplete="list"
                                    aria-label="Password" aria-describedby="passwordHelp">
                                <span class="toggle-password user-eye" id="togglePassword">
                                    <ion-icon name="eye-off" id="eye-icon"></ion-icon>
                                </span>
                            </div>
                            <div data-strong-password='{"target": "#password-hints", "hints": "#password-hints-content", "stripClasses": "strong-password:bg-primary strong-password-accepted:bg-teal-500 h-1.5 flex-auto bg-neutral/20"}'
                                class="rounded-full overflow-hidden mt-2 flex gap-0.5 password-meter"></div>
                            <div id="password-hints-content" class="mb-3">
                                <style>
                                    [data-theme-active="tema4"] #password-hints-content,
                                    [data-theme-active="tema4"] #password-hints-content * {
                                        color: #fff !important;
                                    }
                                </style>
                                <div>
                                    <span data-pw-strength-hint='["Kosong", "Lemah", "Sedang", "Kuat", "Sangat Kuat"]'
                                        class="text-base-content text-sm font-semibold"></span>
                                </div>
                                <h6 class="my-2 text-base font-semibold text-base-content">Password harus berisi:</h6>
                                <ul class="text-base-content/80 space-y-1 text-sm">
                                    <li data-pw-strength-rule="min-length"
                                        class="strong-password-active:text-success flex items-center gap-x-2">
                                        <span class="icon-[tabler--circle-check] hidden size-5 shrink-0" data-check></span>
                                        <span class="icon-[tabler--circle-x] hidden size-5 shrink-0" data-uncheck></span>
                                        Minimal karakter 8.
                                    </li>
                                    <li data-pw-strength-rule="uppercase"
                                        class="strong-password-active:text-success flex items-center gap-x-2">
                                        <span class="icon-[tabler--circle-check] hidden size-5 shrink-0" data-check></span>
                                        <span class="icon-[tabler--circle-x] hidden size-5 shrink-0" data-uncheck></span>
                                        Harus menyertakan huruf kapital.
                                    </li>
                                    <li data-pw-strength-rule="numbers"
                                        class="strong-password-active:text-success flex items-center gap-x-2">
                                        <span class="icon-[tabler--circle-check] hidden size-5 shrink-0" data-check></span>
                                        <span class="icon-[tabler--circle-x] hidden size-5 shrink-0" data-uncheck></span>
                                        Harus menyertakan angka.
                                    </li>
                                    <li data-pw-strength-rule="special-characters"
                                        class="strong-password-active:text-success flex items-center gap-x-2">
                                        <span class="icon-[tabler--circle-check] hidden size-5 shrink-0" data-check></span>
                                        <span class="icon-[tabler--circle-x] hidden size-5 shrink-0" data-uncheck></span>
                                        Harus menyertakan karakter spesial.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top:15px;">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="user-input-group">
                                <input type="password" class="user-input input" name="password_confirmation"
                                    id="passwordConfirmInput" autocomplete="off">
                                <span class="toggle-password user-eye" id="togglePasswordConfirm">
                                    <ion-icon name="eye-off" id="eye-icon-confirm"></ion-icon>
                                </span>
                            </div>
                            <div id="password-match-message" class="mt-2" style="font-size:0.95em;font-weight:500;"></div>
                        </div>
                        <div class="form-group" style="margin-top:15px;">
                            <label class="form-label">Level</label>
                            <select class="user-input" name="type" required>
                                <option value="Admin"
                                    {{ (isset($user) && $user->type == 'Admin') || old('type') == 'Admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="Operator"
                                    {{ (isset($user) && $user->type == 'Operator') || old('type') == 'Operator' ? 'selected' : '' }}>
                                    Operator</option>
                            </select>
                        </div>
                        <div class="user-btn-group">
                            <button type="submit" class="user-btn user-btn-save"><i class="fas fa-save"></i> Save</button>
                            <a href="{{ route('user') }}" class="user-btn user-btn-reset">Reset</a>
                        </div>
                    </form>
                </div>
                <div class="user-table-col flex-grow-1 flex-basis-0" style="min-width:240px;">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td>{{ $u->type }}</td>
                                    <td>
                                        <div class="icon-btn-group">
                                            <a href="{{ route('user.edit', $u->id) }}" class="icon-btn icon-edit"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('user.delete', $u->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="icon-btn icon-delete" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .user-main-box {
            display: flex;
            flex-direction: row;
            gap: 32px;
        }

        .user-form-col,
        .user-table-col {
            flex: 1 1 0;
            min-width: 240px;
            max-width: 100%;
        }

        .user-form-col form,
        .user-table-col table {
            width: 100%;
        }

        @media (max-width: 1200px) {
            .user-main-box {
                gap: 18px;
            }
        }

        @media (max-width: 992px) {
            .user-main-box {
                flex-direction: column !important;
                gap: 18px;
            }

            .user-form-col,
            .user-table-col {
                min-width: 0;
                width: 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 600px) {
            .user-main-box {
                gap: 8px;
            }
        }

        @media (max-width: 992px) {
            .user-main-box {
                flex-direction: column !important;
                gap: 18px;
            }
        }

        html[data-theme-active="tema4"] .user-main-box {
            background: var(--primary) !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-main-box input,
        html[data-theme-active="tema4"] .user-main-box select,
        html[data-theme-active="tema4"] .user-main-box textarea {
            background: var(--tertiary) !important;
            color: #fff !important;
            border: 1px solid #383187 !important;
        }

        html[data-theme-active="tema4"] .user-main-box th,
        html[data-theme-active="tema4"] .user-main-box td {
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-form-box,
        html[data-theme-active="tema4"] .user-table-box {
            background: var(--primary) !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-form-box input,
        html[data-theme-active="tema4"] .user-form-box select,
        html[data-theme-active="tema4"] .user-form-box textarea {
            background: var(--tertiary) !important;
            color: #fff !important;
            border: 1px solid #383187 !important;
        }

        html[data-theme-active="tema4"] .user-table-box {
            background: var(--tertiary) !important;
        }

        html[data-theme-active="tema4"] .user-table-box th,
        html[data-theme-active="tema4"] .user-table-box td {
            color: #fff !important;
        }

        /* Tema 1 */
        :root {
            --primary: #78B3CE;
            --secondary: #F96E2A;
            --tertiary: #FBF8EF;
            --background: #C9E6F0;
            --white: #ffffff;
            --gray: #686868;
            --black: #000000;
        }

        /* Tema 2 */
        html[data-theme-active="tema2"] {
            --primary: #A5B68D;
            --secondary: #DA8359;
            --tertiary: #FBF8EF;
            --background: #E7F0DB;
        }

        /* Tema 3 */
        html[data-theme-active="tema3"] {
            --primary: #A31D1D;
            --secondary: #F29F58;
            --tertiary: #FBF8EF;
            --background: #FFF6D9;
        }

        /* Tema 4 */
        html[data-theme-active="tema4"] {
            --primary: #130F2D;
            --secondary: #4477CE;
            --tertiary: #221F43;
            --background: #19133B;
        }


        .user-header {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            margin-top: 18px;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            color: #000;
        }

        html[data-theme-active="tema4"] .user-header,
        html[data-theme-active="tema4"] .user-table th,
        html[data-theme-active="tema4"] .user-table td,
        html[data-theme-active="tema4"] .form-label,
        html[data-theme-active="tema4"] .user-input,
        html[data-theme-active="tema4"] .user-btn,
        html[data-theme-active="tema4"] .user-note,
        html[data-theme-active="tema4"] .user-desc {
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-input {
            border: 1px solid #fff !important;
        }

        html[data-theme-active="tema4"] .password-hints-content,
        html[data-theme-active="tema4"] .password-hints-content h6,
        html[data-theme-active="tema4"] .password-hints-content ul,
        html[data-theme-active="tema4"] .password-hints-content li {
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-card {
            background: #130F2D !important;
        }

        html[data-theme-active="tema4"] .user-table th,
        html[data-theme-active="tema4"] .user-table td {
            background: #23234a !important;
            color: #fff !important;
            border-color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-input,
        html[data-theme-active="tema4"] .user-input-group input,
        html[data-theme-active="tema4"] .user-input-group select {
            background: #23234a !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .user-btn {
            background: #3498fd !important;
            color: #fff !important;
        }

        .user-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
            padding: 32px 24px;
            width: 900px;
            margin-top: 24px;
        }

        .user-form-table {
            display: flex;
            gap: 32px;
        }

        .user-form-col {
            flex: 1.1;
        }

        .user-table-col {
            flex: 1;
            display: flex;
            align-items: flex-start;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
        }

        .user-table th,
        .user-table td {
            border: 1px solid #e6e6f7;
            color: #000;
            padding: 8px 14px;
            font-size: 1rem;
        }

        .user-table th {
            background: #e6e6f7;
            font-weight: 600;
        }

        .user-table tr {
            background: #fff;
        }

        .user-table tr:nth-child(even) {
            background: #f3f3fa;
        }

        .form-label {
            color: #000;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .user-input,
        .user-input-group input,
        .user-input-group select {
            width: 100%;
            background: #f3f3fa;
            border: 1px solid #ccc;
            border-radius: 8px;
            color: #000;
            padding: 8px 14px;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .user-input[type='select'],
        select.user-input {
            background-position: right 2.2em center !important;
        }

        html[data-theme-active="tema4"] .user-input,
        html[data-theme-active="tema4"] .user-input-group input,
        html[data-theme-active="tema4"] .user-input-group select {
            background: var(--tertiary) !important;
            color: #fff !important;
        }

        .user-input:focus {
            outline: 2px solid #555;
        }

        .user-input-group {
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-eye {
            position: absolute;
            right: 15px;
            top: 40%;
            transform: translateY(-50%);
            color: var(--secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 1.35em;
        }

        /* Tema 1 */
        html[data-theme-active="tema1"] .user-eye {
            color: var(--secondary) !important;
        }

        /* Tema 2 */
        html[data-theme-active="tema2"] .user-eye {
            color: var(--secondary) !important;
        }

        /* Tema 3 */
        html[data-theme-active="tema3"] .user-eye {
            color: var(--secondary) !important;
        }

        /* Tema 4 */
        html[data-theme-active="tema4"] .user-eye {
            color: var(--secondary) !important;
        }

        .user-note {
            color: #aaa;
            font-size: 0.9em;
            margin-top: -8px;
            margin-bottom: 2px;
        }

        .user-desc {
            color: #888;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .user-btn-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .user-btn {
            border: none;
            border-radius: 8px;
            font-weight: 700;
            padding: 8px 24px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .user-btn-save {
            background: var(--secondary, #4b4b9b);
            color: #fff;
        }

        .user-btn-save:hover {
            background: #383187;
        }

        .user-btn-reset {
            text-decoration: none !important;
            background: var(--primary, #3498fd);
            color: #fff;
        }

        .user-btn-reset:hover {
            background: #2176c7;
        }

        /* Tema 1 */
        html[data-theme-active="tema1"] .user-btn-save {
            background: var(--secondary);
        }

        html[data-theme-active="tema1"] .user-btn-save:hover {
            background: #fc9f70;
        }

        html[data-theme-active="tema1"] .user-btn-reset {
            background: var(--primary);
        }

        html[data-theme-active="tema1"] .user-btn-reset:hover {
            background: #a5ddf7;
        }

        /* Tema 2 */
        html[data-theme-active="tema2"] .user-btn-save {
            background: var(--secondary);
        }

        html[data-theme-active="tema2"] .user-btn-save:hover {
            background: #e09f7e;
        }

        html[data-theme-active="tema2"] .user-btn-reset {
            background: var(--primary);
        }

        html[data-theme-active="tema2"] .user-btn-reset:hover {
            background: #def1c3;
        }

        /* Tema 3 */
        html[data-theme-active="tema3"] .user-btn-save {
            background: var(--secondary);
        }

        html[data-theme-active="tema3"] .user-btn-save:hover {
            background: #f3bc8b;
        }

        html[data-theme-active="tema3"] .user-btn-reset {
            background: var(--primary);
        }

        html[data-theme-active="tema3"] .user-btn-reset:hover {
            background: #bd5555;
        }

        /* Tema 4 (dark) */
        html[data-theme-active="tema4"] .user-btn-save {
            background: var(--secondary) !important;
        }

        html[data-theme-active="tema4"] .user-btn-save:hover {
            background: #8cb4fb !important;
        }

        html[data-theme-active="tema4"] .user-btn-reset {
            background: var(--tertiary) !important;
        }

        html[data-theme-active="tema4"] .user-btn-reset:hover {
            background: #4d478d !important;
        }

        .icon-btn-group {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .icon-btn {
            background: none !important;
            border: none !important;
            padding: 0;
            margin: 0;
            color: inherit;
            font-size: 1.15em;
            line-height: 1;
            cursor: pointer;
            box-shadow: none !important;
            outline: none !important;
            transition: color 0.2s;
        }

        .icon-btn:focus {
            outline: none !important;
        }

        .icon-btn i {
            pointer-events: none;
        }

        .icon-edit {
            color: #5069f7 !important;
        }

        .icon-edit:hover {
            color: #6b81fe !important;
        }

        .icon-delete {
            color: #fc5757 !important;
        }

        .icon-delete:hover {
            color: #f97979 !important;
        }

        .password-meter {
            display: flex;
            height: 6px;
            margin-top: 10px;
        }

        .password-meter .strong-password {
            background-color: #ddd;
            flex: 1;
            margin-right: 2px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .strong-password.lemah {
            background-color: #ff4d4d !important;
        }

        .strong-password.sedang {
            background-color: #ff9800 !important;
        }

        .strong-password.kuat {
            background-color: #ffe066 !important;
        }

        .strong-password.sangat-kuat {
            background-color: #009900 !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script>
        const passwordInput = document.getElementById('password-hints');
        const togglePassword = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eye-icon');
        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.setAttribute('name', type === 'password' ? 'eye-off' : 'eye');
            });
        }
        const confirmInput = document.getElementById('passwordConfirmInput');
        const toggleConfirm = document.getElementById('togglePasswordConfirm');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');
        const matchMsg = document.getElementById('password-match-message');
        if (toggleConfirm && confirmInput && eyeIconConfirm) {
            toggleConfirm.addEventListener('click', function() {
                const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmInput.setAttribute('type', type);
                eyeIconConfirm.setAttribute('name', type === 'password' ? 'eye-off' : 'eye');
            });
        }

        function checkPasswordMatch() {
            if (!confirmInput.value) {
                matchMsg.textContent = '';
                matchMsg.style.color = '';
                return;
            }
            if (confirmInput.value === passwordInput.value) {
                matchMsg.textContent = 'Password sesuai';
                matchMsg.style.color = '#28a745';
            } else {
                matchMsg.textContent = 'Password tidak sesuai';
                matchMsg.style.color = '#dc3545';
            }
        }
        if (confirmInput && passwordInput) {
            confirmInput.addEventListener('input', checkPasswordMatch);
            passwordInput.addEventListener('input', checkPasswordMatch);
        }
        const hintContent = document.getElementById('password-hints-content');
        const hintLevel = hintContent.querySelector('[data-pw-strength-hint]');
        const rules = hintContent.querySelectorAll('[data-pw-strength-rule]');
        const meter = document.querySelector('.password-meter');

        function checkRule(rule, val) {
            switch (rule) {
                case 'min-length':
                    return val.length >= 8;
                case 'uppercase':
                    return /[A-Z]/.test(val);
                case 'numbers':
                    return /\d/.test(val);
                case 'special-characters':
                    return /[^A-Za-z0-9]/.test(val);
                default:
                    return false;
            }
        }

        function getStrength(val) {
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/\d/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            return score;
        }

        function getBarClass(score, i) {
            if (score === 4 && i <= 4) return 'sangat-kuat';
            if (score === 3 && i <= 3) return 'kuat';
            if (score === 2 && i <= 2) return 'sedang';
            if (score === 1 && i <= 1) return 'lemah';
            return '';
        }

        function updateStrength() {
            const val = passwordInput.value;
            let score = getStrength(val);
            const levels = ["Kosong", "Lemah", "Sedang", "Kuat", "Sangat Kuat"];
            let levelIdx = 0;
            if (val.length === 0) levelIdx = 0;
            else if (score === 1) levelIdx = 1;
            else if (score === 2) levelIdx = 2;
            else if (score === 3) levelIdx = 3;
            else if (score === 4) levelIdx = 4;
            hintLevel.textContent = levels[levelIdx];
            rules.forEach(rule => {
                const ruleName = rule.getAttribute('data-pw-strength-rule');
                if (checkRule(ruleName, val)) {
                    rule.classList.add('text-success');
                } else {
                    rule.classList.remove('text-success');
                }
            });
            meter.innerHTML = '';
            for (let i = 1; i <= 4; i++) {
                let bar = document.createElement('div');
                bar.className = 'strong-password';
                const barClass = getBarClass(score, i);
                if (barClass) bar.classList.add(barClass);
                meter.appendChild(bar);
            }
        }
        if (passwordInput) passwordInput.addEventListener('input', updateStrength);

        const userForm = document.querySelector('form[action*="user"]');

        function isPasswordValid(val) {
            return val.length >= 8 && /[a-z]/.test(val) && /[A-Z]/.test(val) && /\d/.test(val) && /[^A-Za-z0-9]/.test(val);
        }
        if (userForm && passwordInput && confirmInput) {
            userForm.addEventListener('submit', function(e) {
                const pass = passwordInput.value;
                const conf = confirmInput.value;
                if (pass || conf) {
                    if (!isPasswordValid(pass)) {
                        e.preventDefault();
                        toastr.error(
                            'Password tidak valid. Minimal 8 karakter, huruf besar, huruf kecil, angka, dan simbol.'
                        );
                        return false;
                    }
                    if (pass !== conf) {
                        e.preventDefault();
                        toastr.error('Konfirmasi password tidak sesuai.');
                        return false;
                    }
                }
            });
        }
    </script>
@endpush
