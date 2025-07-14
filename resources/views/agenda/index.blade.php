<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_agenda.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="">
        @include('include.sidebar')

        <div class="main">
            @include('include.navbar', ['pageTitle' => 'Agenda'])
            @include('include.dropdown')

            <div class="cards">
                <div style="width: 50%;">
                    <h2>Kalender</h2>
                    <div class="calendar">
                        <div class="header">
                            <div id="prev" class="btn"><i class="fa-solid fa-arrow-left"></i></div>
                            <div id="month-year" tabindex="0"></div>
                            <div id="next" class="btn"><i class="fa-solid fa-arrow-right"></i></div>
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
                        <div class="btn-group mb-3">
                            <button class="btn btn-outline-primary filter-btn active" data-status="all">All</button>
                            <button class="btn btn-outline-primary filter-btn" data-status="draft">Draft</button>
                            <button class="btn btn-outline-primary filter-btn"
                                data-status="tentative">Tentative</button>
                            <button class="btn btn-outline-primary filter-btn"
                                data-status="confirmed">Confirmed</button>
                            <button class="btn btn-outline-primary filter-btn" data-status="cancel">Canceled</button>
                            <button class="btn btn-outline-primary filter-btn"
                                data-status="reschedule">Reschedule</button>
                        </div>
                        <div id="agenda-items">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/agenda.js') }}"></script>

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
