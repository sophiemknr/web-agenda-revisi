<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="">
        @include('include.sidebar')

        <div class="main">
            @include('include.navbar', ['pageTitle' => 'New'])
            @include('include.dropdown')

            <h2 class="text-center fw-bold mt-4">Tambah Agenda</h2>

            <div class="form-container">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="p-4" action="{{ route('agenda.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="date" class="form-label fw-bold">Tanggal</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label for="jam" class="form-label fw-bold">Jam</label>
                        <input type="time" class="form-control" name="jam" required>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Kegiatan</label>
                        <textarea class="form-control" name="title" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Keterangan</label>
                        <textarea class="form-control" name="description" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tempat" class="form-label fw-bold">Tempat</label>
                        <input type="text" class="form-control" name="tempat" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="tentative">Tentative</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancel">Cancelled</option>
                            <option value="reschedule">Reschedule</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="disposition" class="form-label fw-bold">Disposisi</label>
                        <input type="text" class="form-control" name="disposition" required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Simpan Agenda</button>
                </form>
            </div>

            <style>
                .form-container {
                    max-width: 600px;
                    background-color: #f8f9fa;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    margin: auto;
                    margin-top: 20px;
                }

                .form-label {
                    font-weight: bold;
                }
            </style>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toastr Notification
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
