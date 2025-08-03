@extends('layouts.app', ['pageTitle' => 'Laporan'])

@section('title', 'Laporan')

@section('content')
    <h2 class="fw-bold text-center">Laporan Agenda</h2>

    <section class="content mt-4">
        <div class="container-fluid">
            <div class="bg-white p-4 rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Filter Laporan</h5>
                    <a href="{{ route('laporan.pdf', request()->all()) }}" target="_blank" class="btn fw-bold"
                        style="background-color: var(--secondary); color: #ffffff;">
                        <ion-icon name="print"></ion-icon> <span>Print PDF</span>
                    </a>
                </div>

                <form method="GET" action="{{ route('laporan') }}" class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <div class="form-group">
                        <label for="tanggal-awal">Tanggal Awal</label>
                        <input type="date" id="tanggal-awal" name="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">
                    </div>
                    <span class="px-3 py-1 fw-bold rounded align-self-end s-d-span"
                        style="background-color: var(--primary); color: #FFFFFF;">s/d</span>
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

                    <button type="submit" class="btn fw-bold align-self-end"
                        style="background-color: var(--secondary); color: #fff;">Filter</button>
                </form>

                <form method="GET" class="d-flex flex-wrap align-items-center mb-3" style="gap: 10px;">
                    <label for="log_show" class="form-label mb-0">Show
                        <select name="log_show" id="log_show" class="form-select d-inline-block w-auto"
                            onchange="this.form.submit()">
                            @foreach ([5, 10, 25, 50, 100] as $opt)
                                <option value="{{ $opt }}" {{ isset($show) && $show == $opt ? 'selected' : '' }}>
                                    {{ $opt }}
                                </option>
                            @endforeach
                        </select>
                        entries
                    </label>
                    <input type="text" name="log_search" value="{{ isset($search) ? $search : '' }}"
                        class="form-control w-auto" placeholder="Cari aktivitas/user..." style="min-width:180px;" />
                    <button type="submit" class="btn btn-secondary">Cari</button>
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
                                    <td>{{ \Carbon\Carbon::parse($agenda->date)->format('d/m/Y') }}</td>
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
                <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="log-pagination-info">
                        @if (
                            $agendas instanceof \Illuminate\Pagination\LengthAwarePaginator ||
                                $agendas instanceof \Illuminate\Pagination\Paginator)
                            Menampilkan {{ $agendas->firstItem() ?? 0 }} - {{ $agendas->lastItem() ?? 0 }} dari
                            {{ $agendas->total() }} entri
                        @else
                            <span class="text-danger">Pagination tidak aktif. Pastikan variabel $agendas di controller
                                menggunakan paginate().</span>
                        @endif
                    </div>
                    <div style="flex:1;">
                        @if (
                            $agendas instanceof \Illuminate\Pagination\LengthAwarePaginator ||
                                $agendas instanceof \Illuminate\Pagination\Paginator)
                            <div class="pagination">
                                <a href="{{ $agendas->url(1) }}"
                                    @if ($agendas->onFirstPage()) style="pointer-events:none;opacity:0.5;" @endif>&lt;&lt;</a>
                                <a href="{{ $agendas->previousPageUrl() ?? '#' }}"
                                    @if ($agendas->onFirstPage()) style="pointer-events:none;opacity:0.5;" @endif>&lt;</a>
                                @php
                                    $current = $agendas->currentPage();
                                    $last = $agendas->lastPage();
                                    $pages = [];
                                    if ($last <= 3) {
                                        for ($i = 1; $i <= $last; $i++) {
                                            $pages[] = $i;
                                        }
                                    } else {
                                        if ($current == 1) {
                                            $pages = [1, 2, 3];
                                        } elseif ($current == $last) {
                                            $pages = [$last - 2, $last - 1, $last];
                                        } else {
                                            $pages = [$current - 1, $current, $current + 1];
                                        }
                                    }
                                @endphp
                                @foreach ($pages as $page)
                                    @if ($page == $current)
                                        <a href="#" class="active">{{ $page }}</a>
                                    @else
                                        <a href="{{ $agendas->url($page) }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                                <a href="{{ $agendas->nextPageUrl() ?? '#' }}"
                                    @if (!$agendas->hasMorePages()) style="pointer-events:none;opacity:0.5;" @endif>&gt;</a>
                                <a href="{{ $agendas->url($agendas->lastPage()) }}"
                                    @if (!$agendas->hasMorePages()) style="pointer-events:none;opacity:0.5;" @endif>&gt;&gt;</a>
                            </div>
                        @else
                            <span class="text-danger">Pagination tidak aktif. Pastikan variabel $agendas di controller
                                menggunakan paginate().</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        h2.fw-bold.text-center {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            margin-top: 18px;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            color: #000;
        }

        html[data-theme-active="tema4"] .s-d-span {
            background-color: var(--tertiary) !important;
            color: #fff !important;
        }

        html[data-theme-active="tema4"] .form-control[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(38%) sepia(98%) saturate(1200%) hue-rotate(180deg) brightness(1.1);
        }

        .badge.bg-draft {
            background-color: #007bff;
        }

        .badge.bg-tentative {
            background-color: #ff9800;
        }

        .badge.bg-confirm {
            background-color: #28a745;
        }

        .badge.bg-cancel {
            background-color: #dc3545;
        }

        .badge.bg-reschedule {
            background-color: #FFD43B;
        }
    </style>
@endpush
