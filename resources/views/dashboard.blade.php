@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
    <div class="cardBox">
        {{-- Kode untuk card-card status agenda yang sudah ada --}}
        @php
            $startDate = \Carbon\Carbon::now()->startOfMonth()->toDateString();
            $endDate = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        @endphp

        <a href="{{ route('laporan', ['status' => 'draft', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
            style="text-decoration: none; color: inherit;">
            <div class="card">
                <div>
                    <div class="numbers">{{ $draftCount }}</div>
                    <div class="cardName">Draft</div>
                </div>
                <div class="iconBox"><ion-icon name="pencil-outline"></ion-icon></div>
            </div>
        </a>
        <a href="{{ route('laporan', ['status' => 'tentative', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
            style="text-decoration: none; color: inherit;">
            <div class="card">
                <div>
                    <div class="numbers">{{ $tentativeCount }}</div>
                    <div class="cardName">Tentative</div>
                </div>
                <div class="iconBox"><ion-icon name="help-circle-outline"></ion-icon></div>
            </div>
        </a>
        <a href="{{ route('laporan', ['status' => 'confirm', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
            style="text-decoration: none; color: inherit;">
            <div class="card">
                <div>
                    <div class="numbers">{{ $confirmCount }}</div>
                    <div class="cardName">Confirm</div>
                </div>
                <div class="iconBox"><ion-icon name="checkmark-circle-outline"></ion-icon></div>
            </div>
        </a>
        <a href="{{ route('laporan', ['status' => 'cancel', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
            style="text-decoration: none; color: inherit;">
            <div class="card">
                <div>
                    <div class="numbers">{{ $cancelCount }}</div>
                    <div class="cardName">Cancel</div>
                </div>
                <div class="iconBox"><ion-icon name="close-circle-outline"></ion-icon></div>
            </div>
        </a>
        <a href="{{ route('laporan', ['status' => 'reschedule', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
            style="text-decoration: none; color: inherit;">
            <div class="card">
                <div>
                    <div class="numbers">{{ $rescheduleCount }}</div>
                    <div class="cardName">Reschedule</div>
                </div>
                <div class="iconBox"><ion-icon name="calendar-outline"></ion-icon></div>
            </div>
        </a>
    </div>

    {{-- KODE BARU UNTUK LOG ACTIVITY --}}
    <div class="log-activity-container">
        <h2 class="log-activity-title">Log Activity</h2>
        <div class="log-activity-card">
            <form method="GET" class="d-flex flex-wrap align-items-center mb-3" style="gap: 10px;">
                <label for="log_show" class="form-label mb-0">Show
                    <select name="log_show" id="log_show" class="form-select d-inline-block w-auto"
                        onchange="this.form.submit()">
                        @foreach ([5, 10, 25, 50, 100] as $opt)
                            <option value="{{ $opt }}" {{ $show == $opt ? 'selected' : '' }}>{{ $opt }}
                            </option>
                        @endforeach
                    </select>
                    entries
                </label>
                <input type="text" name="log_search" value="{{ $search }}" class="form-control w-auto"
                    placeholder="Cari aktivitas/user..." style="min-width:180px;" />
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
            <table class="log-activity-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Aktivitas</th>
                        <th>User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->subject }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">Tidak ada aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap">
                <div class="log-pagination-info">
                    Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }}
                    entri
                </div>
                <div style="flex:1;">
                    <div class="pagination">
                        {{-- First Page --}}
                        <a href="{{ $logs->url(1) }}"
                            @if ($logs->onFirstPage()) style="pointer-events:none;opacity:0.5;" @endif>&lt;&lt;</a>
                        {{-- Previous Page --}}
                        <a href="{{ $logs->previousPageUrl() ?? '#' }}"
                            @if ($logs->onFirstPage()) style="pointer-events:none;opacity:0.5;" @endif>&lt;</a>
                        {{-- Current Page --}}
                        <a href="#" class="active">{{ $logs->currentPage() }}</a>
                        {{-- Next Page --}}
                        <a href="{{ $logs->nextPageUrl() ?? '#' }}"
                            @if (!$logs->hasMorePages()) style="pointer-events:none;opacity:0.5;" @endif>&gt;</a>
                        {{-- Last Page --}}
                        <a href="{{ $logs->url($logs->lastPage()) }}"
                            @if (!$logs->hasMorePages()) style="pointer-events:none;opacity:0.5;" @endif>&gt;&gt;</a>
                    </div>
                </div>
            </div>
            <style>
                .pagination-custom nav {
                    font-size: 0.95rem;
                }

                .pagination-custom .pagination {
                    margin-bottom: 0;
                    gap: 2px;
                }

                .pagination-custom .page-link {
                    padding: 2px 8px;
                    font-size: 0.95em;
                    min-width: 28px;
                    min-height: 28px;
                    line-height: 1.2;
                }

                .pagination-custom .page-item .page-link svg {
                    width: 1em;
                    height: 1em;
                }
            </style>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif
    </script>
@endpush
