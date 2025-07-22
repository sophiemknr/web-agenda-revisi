@extends('layouts.app', ['pageTitle' => 'Edit Profile'])

@section('title', 'Edit Profile')

@section('content')
    <h2 class="editprofile-title">Edit Profile</h2>
    <div class="editprofile-container">
        <div class="editprofile-card">
            <form class="editprofile-form">
                <div class="editprofile-row">
                    <div class="editprofile-col">
                        <label class="editprofile-label">Name</label>
                        <input type="text" class="editprofile-input" name="name" value="{{ $user->name ?? '' }}"
                            autocomplete="off">
                    </div>
                    <div class="editprofile-col">
                        <label class="editprofile-label">Password Baru</label>
                        <div class="editprofile-input-group">
                            <input type="password" class="editprofile-input" name="password" id="passwordInput"
                                placeholder="*isi jika ingin diubah" autocomplete="off">
                            <span class="toggle-password editprofile-eye" id="togglePassword">
                                <ion-icon name="eye-off" id="eye-icon"></ion-icon>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="editprofile-row">
                    <div class="editprofile-col">
                        <label class="editprofile-label">Username</label>
                        <input type="text" class="editprofile-input" name="username" value="{{ $user->username ?? '' }}"
                            autocomplete="off">
                    </div>
                    <div class="editprofile-col">
                        <label class="editprofile-label">Konfirmasi Password</label>
                        <div class="editprofile-input-group">
                            <input type="password" class="editprofile-input" name="password_confirmation"
                                id="passwordConfirmInput" autocomplete="off">
                            <span class="toggle-password editprofile-eye" id="togglePasswordConfirm">
                                <ion-icon name="eye-off" id="eye-icon-confirm"></ion-icon>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="editprofile-actions">
                    <button type="submit" class="editprofile-btn save-btn"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="editprofile-btn cancel-btn"
                        onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .editprofile-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: var(--text, #23234a);
        }

        .editprofile-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 40vh;
        }

        .editprofile-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.12);
            padding: 28px 24px 20px 24px;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .editprofile-form {
            width: 100%;
        }

        .editprofile-row {
            display: flex;
            gap: 24px;
            margin-bottom: 18px;
        }

        .editprofile-col {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .editprofile-label {
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text, #23234a);
        }

        .editprofile-input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .editprofile-input {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #23234a0d;
            color: var(--text, #23234a);
            padding: 8px 38px 8px 14px;
            font-size: 1rem;
            margin-bottom: 0;
        }

        .editprofile-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--secondary, #4b4b9b);
            font-size: 1.2em;
        }

        .editprofile-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 18px;
        }

        .editprofile-btn {
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .save-btn {
            background: var(--secondary, #4b4b9b);
            color: #fff;
        }

        .save-btn:hover {
            background: #383187;
        }

        .cancel-btn {
            background: var(--primary, #3498fd);
            color: #fff;
        }

        .cancel-btn:hover {
            background: #2176bd;
        }

        /* Theme 4: dark mode */


        html[data-theme-active="tema4"] .editprofile-card {
            background-color: #130F2D !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .editprofile-title,
        html[data-theme-active="tema4"] .editprofile-label {
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .editprofile-input {
            background: #221F43 !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .editprofile-eye {
            color: var(--secondary, #4477CE) !important;
        }

        html[data-theme-active="tema4"] .editprofile-btn.save-btn {
            background: var(--secondary, #4477CE) !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .editprofile-btn.cancel-btn {
            background: #221F43 !important;
            color: #fff !important;
        }

        @media (max-width: 700px) {
            .editprofile-row {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // Password toggle
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.querySelector('ion-icon').setAttribute('name', type === 'password' ? 'eye-off' :
                        'eye');
                });
            }
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('passwordConfirmInput');
            if (togglePasswordConfirm && passwordConfirmInput) {
                togglePasswordConfirm.addEventListener('click', function() {
                    const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordConfirmInput.setAttribute('type', type);
                    this.querySelector('ion-icon').setAttribute('name', type === 'password' ? 'eye-off' :
                        'eye');
                });
            }
        });
    </script>
@endpush
