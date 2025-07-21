@extends('layouts.app', ['pageTitle' => 'New'])

@section('title', 'New')

@section('content')
    <h2 class="text-center fw-bold mt-4">Tambah Agenda</h2>
    <div class="agenda-form-card">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="agenda-form-grid" action="{{ route('agenda.store') }}" method="POST">
            @csrf
            <div class="agenda-form-row">
                <div class="agenda-form-group">
                    <label for="date" class="agenda-label">Tanggal</label>
                    <input type="date" class="agenda-input" name="date" required>
                </div>
                <div class="agenda-form-group">
                    <label for="tempat" class="agenda-label">Tempat</label>
                    <input type="text" class="agenda-input" name="tempat" required placeholder="Enter text">
                </div>
            </div>
            <div class="agenda-form-row">
                <div class="agenda-form-group">
                    <label for="jam" class="agenda-label">Jam</label>
                    <input type="time" class="agenda-input" name="jam" required>
                </div>
                <div class="agenda-form-group">
                    <label for="status" class="agenda-label">Status</label>
                    <select class="agenda-input" name="status" required>
                        <option value="">- Pilih -</option>
                        <option value="draft">Draft</option>
                        <option value="tentative">Tentative</option>
                        <option value="confirm">Confirm</option>
                        <option value="cancel">Cancel</option>
                    </select>
                </div>
            </div>
            <div class="agenda-form-row">
                <div class="agenda-form-group">
                    <label for="title" class="agenda-label">Kegiatan</label>
                    <textarea class="agenda-input" name="title" rows="2" required></textarea>
                </div>
                <div class="agenda-form-group">
                    <label for="disposition" class="agenda-label">Mewakilkan/Disposisi</label>
                    <input type="text" class="agenda-input" name="disposition" required
                        placeholder="Mewakilkan/Disposisi">
                </div>
            </div>
            <div class="agenda-form-row">
                <div class="agenda-form-group" style="width:100%;">
                    <label for="description" class="agenda-label">Keterangan</label>
                    <textarea class="agenda-input" name="description" rows="2" required></textarea>
                </div>
            </div>
            <div class="agenda-form-row" style="justify-content: flex-end;">
                <button type="submit" class="btn btn-simpan">Simpan Agenda</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
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
@endpush

@push('scripts')
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
@endpush
