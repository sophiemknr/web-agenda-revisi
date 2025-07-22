@extends('layouts.app', ['pageTitle' => 'User'])

@section('title', 'Manajemen User')

@section('content')
    <h2 class="user-header">User</h2>
    <section class="user-section">
        <div class="user-card">
            <div class="user-form-table">
                <div class="user-form-col">
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
                                <input type="password" class="user-input" name="password" id="passwordInput"
                                    placeholder="*isi jika ingin diubah" autocomplete="off">
                                <span class="toggle-password user-eye" id="togglePassword">
                                    <ion-icon name="eye-off" id="eye-icon"></ion-icon>
                                </span>
                            </div>
                            <small class="user-desc">Password minimal 8 karakter, harus ada huruf besar, huruf kecil, angka,
                                dan simbol.</small>
                        </div>
                        <div class="form-group" style="margin-top:15px;">
                            <label class="form-label">Konfirmasi Password</label>
                            <div class="user-input-group">
                                <input type="password" class="user-input" name="password_confirmation"
                                    id="passwordConfirmInput" autocomplete="off">
                                <span class="toggle-password user-eye" id="togglePasswordConfirm">
                                    <ion-icon name="eye-off" id="eye-icon-confirm"></ion-icon>
                                </span>
                            </div>
                            <small class="user-desc">Password minimal 8 karakter, harus ada huruf besar, huruf kecil, angka,
                                dan simbol.</small>
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
                <div class="user-table-col">
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
    </section>
@endsection

@push('styles')
    <style>
        /* Tema 1 (Default) */
        :root {
            --primary: #78B3CE;
            --secondary: #F96E2A;
            --tertiary: #FBF8EF;
            --background: #C9E6F0;
            --white: #ffffff;
            --gray: #686868;
            --black: #000000;
        }

        /* Tema 2 (Hijau & Coklat) */
        html[data-theme-active="tema2"] {
            --primary: #A5B68D;
            --secondary: #DA8359;
            --tertiary: #FBF8EF;
            --background: #E7F0DB;
        }

        /* Tema 3 (Merah & Kuning) */
        html[data-theme-active="tema3"] {
            --primary: #A31D1D;
            --secondary: #F29F58;
            --tertiary: #FBF8EF;
            --background: #FFF6D9;
        }

        /* Tema 4 (Biru Tua) */
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

        /* Tema 4: dark background, light text */
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

        /* Tema lain: light background, dark text */
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

        /* Perbaiki posisi icon dropdown pada select agar lebih ke kiri */
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
            /* default secondary */
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

        /* Button Save = secondary, Button Reset = primary */
        .user-btn-save {
            background: var(--secondary, #4b4b9b);
            color: #fff;
        }

        .user-btn-save:hover {
            background: #383187;
        }

        .user-btn-reset {
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
    </style>
@endpush

@push('scripts')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.setAttribute('name', 'eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.setAttribute('name', 'eye-off');
            }
        });
        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordConfirmInput');
            const eyeIcon = document.getElementById('eye-icon-confirm');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.setAttribute('name', 'eye');
            } else {
                passwordField.type = 'password';
                eyeIcon.setAttribute('name', 'eye-off');
            }
        });
    </script>
@endpush
