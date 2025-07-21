@extends('layouts.app', ['pageTitle' => 'Laporan'])

@section('title', 'Laporan')

@section('content')
    <h2 class="fw-bold text-center">Laporan Agenda</h2>

    <section class="content mt-4">
        <div class="container-fluid">
            <div class="bg-white p-4 rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Filter Laporan</h5>
                    <button class="btn fw-bold" style="background-color: #F96E2A; color: #ffffff;" onclick="window.print()">
                        <ion-icon name="print"></ion-icon> <span>Print PDF</span>
                    </button>
                </div>

                <form method="GET" action="{{ route('laporan') }}" class="d-flex flex-wrap align-items-center gap-3 mb-4">
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
                            <option value="confirm" {{ request('status') == 'confirm' ? 'selected' : '' }}>
                                Confirm</option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>
                                Cancel</option>
                            <option value="reschedule" {{ request('status') == 'reschedule' ? 'selected' : '' }}>Reschedule
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary align-self-end">Filter</button>
                </form>

                <div class="table-responsive">
                    <table class="laporan-table log-activity-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Tempat</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $agenda)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($agenda->date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $agenda->title }}</td>
                                    <td>{{ $agenda->tempat }}</td>
                                    <td>{{ $agenda->user->name ?? 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-{{ $agenda->status === 'confirm' || $agenda->status === 'confirmed' ? 'confirm' : strtolower($agenda->status) }}">{{ $agenda->status === 'confirm' || $agenda->status === 'confirmed' ? 'CONFIRM' : strtoupper($agenda->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .badge.bg-draft {
            background-color: #007bff;
        }

        .badge.bg-tentative {
            background-color: #ffc107;
            color: #000 !important;
        }

        .badge.bg-confirm {
            background-color: #28a745;
        }

        .badge.bg-cancel {
            background-color: #dc3545;
        }

        .badge.bg-reschedule {
            background-color: #fd7e14;
        }
    </style>
@endpush
