@extends('layouts.app', ['pageTitle' => 'Reschedule'])

@section('title', 'Reschedule')

@section('content')
    <h2 class="text-center">Reschedule Agenda</h2>

    <div class="form-container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('agenda.reschedule.update', $agenda->id) }}" method="POST" class="p-4">
            @csrf
            <input type="hidden" name="agenda_id" value="{{ $agenda->id }}" />

            <div class="mb-3">
                <label for="jam" class="form-label">Jam</label>
                <input type="time" class="form-control readonly-field" name="jam" value="{{ $agenda->jam }}"
                    readonly />
            </div>

            <div class="mb-3">
                <label for="kegiatan" class="form-label">Kegiatan</label>
                <textarea class="form-control readonly-field" name="kegiatan" rows="2" readonly>{{ $agenda->title }}</textarea>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control readonly-field" name="keterangan" rows="2" readonly>{{ $agenda->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="tempat" class="form-label">Tempat</label>
                <input type="text" class="form-control readonly-field" name="tempat" value="{{ $agenda->tempat }}"
                    readonly />
            </div>

            <div class="mb-3">
                <label for="status_reschedule" class="form-label">Status (Reschedule)</label>
                <input type="text" class="form-control readonly-field" name="status_reschedule" value="reschedule"
                    readonly />
            </div>

            <div class="mb-3">
                <label for="disposition" class="form-label">Disposition</label>
                <input type="text" class="form-control readonly-field" name="disposition"
                    value="{{ old('disposition', $agenda->disposition ?? '') }}" readonly />
            </div>

            <div class="mb-3">
                <label for="tanggal_reschedule" class="form-label">Tanggal Reschedule</label>
                <input type="date" class="form-control" name="tanggal_reschedule"
                    value="{{ old('tanggal_reschedule', $agenda->date) }}" required />
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" required>
                    <option value="draft" {{ $agenda->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="tentative" {{ $agenda->status == 'tentative' ? 'selected' : '' }}>Tentative
                    </option>
                    <!-- Removed legacy 'confirmed' option -->
                    <option value="confirm" {{ $agenda->status == 'confirm' ? 'selected' : '' }}>Confirm
                    </option>
                    <option value="cancel" {{ $agenda->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                </select>
            </div>

            <button type="submit" class="btn btn-danger w-100">Simpan Agenda</button>
        </form>
    </div>
    </div>
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

        h1,
        h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: #333;
        }

        /* Non-editable fields styling */
        .readonly-field[readonly],
        .readonly-field[readonly]:hover,
        .readonly-field[readonly]:focus,
        .readonly-field[readonly],
        .readonly-field[readonly]:active,
        textarea.readonly-field[readonly],
        textarea.readonly-field[readonly]:hover,
        textarea.readonly-field[readonly]:focus {
            background-color: #e9ecef !important;
            color: #6c757d !important;
            cursor: not-allowed !important;
            /* Shows stop sign cursor */
            border: 1px solid #ced4da;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush
