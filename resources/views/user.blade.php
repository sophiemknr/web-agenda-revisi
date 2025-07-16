@extends('layouts.app', ['pageTitle' => 'User'])

@section('title', 'Manajemen User')

@section('content')
    <section class="cards">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header bg-light text-dark fw-bold">
                    {{ isset($user) ? 'Form Edit User' : 'Form Tambah User' }}
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form User -->
                    <form method="POST" action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ $user->name ?? old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" name="username"
                                value="{{ $user->username ?? old('username') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ $user->email ?? old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="passwordInput"
                                    placeholder="{{ isset($user) ? '*Isi jika ingin diubah' : '' }}"
                                    {{ isset($user) ? '' : 'required' }}
                                    title="Password minimal 8 karakter, harus ada huruf besar, huruf kecil, angka, dan simbol">
                                <span class="input-group-text" id="togglePassword" style="cursor:pointer">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                            <small class="form-text text-muted">Password minimal 8 karakter, harus ada huruf besar, huruf
                                kecil, angka, dan simbol.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="passwordConfirmInput">
                                <span class="input-group-text" id="togglePasswordConfirm" style="cursor:pointer">
                                    <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Level</label>
                            <select class="form-select" name="type" required>
                                <option value="Admin"
                                    {{ (isset($user) && $user->type == 'Admin') || old('type') == 'Admin' ? 'selected' : '' }}>
                                    Admin</option>
                                <option value="Operator"
                                    {{ (isset($user) && $user->type == 'Operator') || old('type') == 'Operator' ? 'selected' : '' }}>
                                    Operator
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-save"></i> {{ isset($user) ? 'Update' : 'Save' }}
                            </button>
                            <a href="{{ route('user') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>

                    <!-- Table User -->
                    @if (!isset($user))
                        <hr>
                        <h5 class="mt-4 fw-bold">Daftar User</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center mt-3">
                                <thead class="table-light">
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
                                                <a href="{{ route('user.edit', $u->id) }}" class="btn btn-primary btn-sm"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('user.delete', $u->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .cards {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 20px;
            padding-bottom: 40px;
        }

        .cards .container {
            width: 100%;
            max-width: 800px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 2px solid #dee2e6;
        }

        .card-body {
            padding: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://kit.fontawesome.com/4b2b2b2b2b.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordConfirmInput');
            const eyeIcon = document.getElementById('eyeIconConfirm');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
