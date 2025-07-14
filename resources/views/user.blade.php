<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <!-- CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="">
        <!-- SIDEBAR -->
        @include('include.sidebar')

        <!-- MAIN -->
        <div class="main">
            @include('include.navbar', ['pageTitle' => 'User'])
            @include('include.dropdown')

            <!-- CARDS -->
            <section class="cards">
                <div class="container mt-4">
                    <h3 class="text-center fw-bold">Users</h3>
                    <div class="card">
                        <div class="card-header bg-light text-dark">

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
                            <form method="POST"
                                action="{{ isset($user) ? route('user.update', $user->id) : route('user.store') }}">
                                @csrf
                                @if (isset($user))
                                    @method('POST')
                                @endif
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="{{ isset($user) ? '*Isi jika ingin diubah' : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </form>

                            <!-- Table User -->
                            <table class="table table-bordered text-center mt-4">
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
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->type }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('user.delete', $user->id) }}"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <style>
                .cards {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-top: 20px;
                }

                .cards .container {
                    width: 100%;
                    max-width: 600px;
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
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ION ICONS -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
