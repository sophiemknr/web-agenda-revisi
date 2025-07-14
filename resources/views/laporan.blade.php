<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-color: #C9E6F0;">
    <div class="d-flex">
        @include('include.sidebar')

        <div class="main flex-grow-1">
            @include('include.navbar', ['pageTitle' => 'Laporan'])
            @include('include.dropdown')

            <h2 class="fw-bold text-center mt-4">Laporan Agenda</h2>

            <section class="content mt-4">
                <div class="container">
                    <div class="bg-white p-4 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Filter Laporan</h5>
                            <button class="btn fw-bold" style="background-color: #F96E2A; color: #ffffff;"
                                onclick="window.print()">
                                <ion-icon name="print"></ion-icon> <span>Print PDF</span>
                            </button>
                        </div>

                        <form method="GET" action="{{ route('laporan') }}"
                            class="d-flex flex-wrap align-items-center gap-3 mb-4">
                            <div class="form-group">
                                <label for="tanggal-awal">Tanggal Awal</label>
                                <input type="date" id="tanggal-awal" name="tanggal_awal" class="form-control"
                                    value="{{ request('tanggal_awal') }}">
                            </div>
                            <span class="px-3 py-1 fw-bold rounded align-self-end"
                                style="background-color: #78B3CE; color: #FFFFFF;">s/d</span>
                            <div class="form-group">
                                <label for="tanggal-akhir">Tanggal Akhir</label>
                                <input type="date" id="tanggal-akhir" name="tanggal_akhir" class="form-control"
                                    value="{{ request('tanggal_akhir') }}">
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua
                                    </option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="tentative" {{ request('status') == 'tentative' ? 'selected' : '' }}>
                                        Tentative</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="reschedule"
                                        {{ request('status') == 'reschedule' ? 'selected' : '' }}>Reschedule</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary align-self-end">Filter</button>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-white text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Uraian Kegiatan</th>
                                        <th>Tempat</th>
                                        <th>Oleh</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agendas as $agenda)
                                        <tr>
                                            <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</td>
                                            <td>{{ $agenda->title }}</td>
                                            <td>{{ $agenda->tempat }}</td>
                                            <td>{{ $agenda->user->name ?? 'N/A' }}</td>
                                            <td><span
                                                    class="badge bg-{{ strtolower($agenda->status) }}">{{ ucfirst($agenda->status) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <style>
        .badge.bg-draft {
            background-color: #007bff;
        }

        .badge.bg-tentative {
            background-color: #ffc107;
            color: #000 !important;
        }

        .badge.bg-confirmed {
            background-color: #28a745;
        }

        .badge.bg-cancel {
            background-color: #dc3545;
        }

        .badge.bg-reschedule {
            background-color: #fd7e14;
        }
    </style>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
