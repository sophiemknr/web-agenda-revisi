@extends('layouts.app', ['pageTitle' => 'Agenda'])

@section('title', 'Agenda')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/style_agenda.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
    <div class="cards">
        <div style="width: 50%;">
            <h2>Kalender</h2>
            <div class="calendar">
                <div class="header">
                    <div id="prev" class="btn calendar-arrow">
                        <ion-icon name="chevron-back-circle" class="calendar-chevron"></ion-icon>
                    </div>
                    <div id="month-year" tabindex="0"></div>
                    <div id="next" class="btn calendar-arrow">
                        <ion-icon name="chevron-forward-circle" class="calendar-chevron"></ion-icon>
                    </div>
                </div>
                <div class="weekdays">
                    <div>Sen</div>
                    <div>Sel</div>
                    <div>Rab</div>
                    <div>Kam</div>
                    <div>Jum</div>
                    <div class="red">Sab</div>
                    <div class="red">Min</div>
                </div>
                <div class="days" id="days"></div>
            </div>
        </div>

        <div style="width: 48%;">
            <h2>Agenda</h2>
            <div class="agenda-container" id="agenda-list">
                <div class="btn-group mb-3" style="position: relative;">
                    <div class="filter-dropdown-wrapper" style="position: relative; display: inline-block; width: 220px;">
                        <select class="filter-dropdown" id="agenda-status-filter" style="width: 100%; padding-right: 40px;">
                            <option value="all">All</option>
                            <option value="draft">Draft</option>
                            <option value="tentative">Tentative</option>
                            <option value="confirm">Confirm</option>
                            <option value="cancel">Cancel</option>
                            <option value="reschedule">Reschedule</option>
                        </select>
                        <span class="dropdown-icon"
                            style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <ion-icon name="chevron-down-outline" style="font-size: 1.3em; color: #686868;"></ion-icon>
                        </span>
                    </div>
                    <div class="filter-btn-group" style="display:none;">
                        <button class="filter-btn" data-status="all"></button>
                        <button class="filter-btn" data-status="draft"></button>
                        <button class="filter-btn" data-status="tentative"></button>
                        <button class="filter-btn" data-status="confirm"></button>
                        <button class="filter-btn" data-status="cancel"></button>
                        <button class="filter-btn" data-status="reschedule"></button>
                    </div>
                </div>
                <div id="agenda-items">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/agenda.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // Toastr Notification
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        // Dropdown filter integration with agenda.js
        document.getElementById('agenda-status-filter').addEventListener('change', function() {
            var status = this.value;
            // Simulate filter button click to reuse agenda.js logic
            var filterBtn = Array.from(document.querySelectorAll('.filter-btn')).find(btn => btn.dataset.status ===
                status);
            if (filterBtn) {
                filterBtn.click();
            } else {
                // If 'all' or not found, trigger the 'all' filter
                var allBtn = Array.from(document.querySelectorAll('.filter-btn')).find(btn => btn.dataset.status ===
                    'all');
                if (allBtn) allBtn.click();
            }
        });
    </script>
@endpush
