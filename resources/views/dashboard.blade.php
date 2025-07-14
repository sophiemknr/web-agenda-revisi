<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container">
        @include('include.sidebar')
        <div class="main">
            @include('include.navbar')
            @include('include.dropdown')

            <div class="cardBox">
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
                <a href="{{ route('laporan', ['status' => 'confirmed', 'tanggal_awal' => $startDate, 'tanggal_akhir' => $endDate]) }}"
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
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
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
