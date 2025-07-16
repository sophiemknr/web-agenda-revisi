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
            <table class="log-activity-table">
                <thead>
                    <tr>
                        <th>Date Time</th>
                        <th>Activity</th>
                        <th>By</th>
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
                            <td colspan="3" style="text-align: center;">No recent activity.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
