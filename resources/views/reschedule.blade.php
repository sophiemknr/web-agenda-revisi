@extends('layouts.app', ['pageTitle' => 'Reschedule'])

@section('title', 'Reschedule')

@section('content')
    <h2 class="reschedule-title">Reschedule Agenda</h2>
    <section class="content mt-4">
        <div class="container-fluid px-0">
            <div class="agenda-form-box agenda-form-card w-100" style="max-width:100%;">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('agenda.reschedule.update', $agenda->id) }}" method="POST" class="agenda-form-grid">
                    @csrf
                    <input type="hidden" name="agenda_id" value="{{ $agenda->id }}" />
                    <div class="agenda-form-row">
                        <div class="agenda-form-group">
                            <label for="jam" class="agenda-label">Jam</label>
                            <input type="time" class="agenda-input readonly-field" name="jam"
                                value="{{ $agenda->jam }}" readonly />
                        </div>
                        <div class="agenda-form-group">
                            <label for="tempat" class="agenda-label">Tempat</label>
                            <input type="text" class="agenda-input readonly-field" name="tempat"
                                value="{{ $agenda->tempat }}" readonly />
                        </div>
                    </div>
                    <div class="agenda-form-row">
                        <div class="agenda-form-group">
                            <label for="kegiatan" class="agenda-label">Kegiatan</label>
                            <textarea class="agenda-input readonly-field" name="kegiatan" rows="2" readonly>{{ $agenda->title }}</textarea>
                        </div>
                        <div class="agenda-form-group">
                            <label for="disposition" class="agenda-label">Disposition</label>
                            <input type="text" class="agenda-input readonly-field" name="disposition"
                                value="{{ old('disposition', $agenda->disposition ?? '') }}" readonly />
                        </div>
                    </div>
                    <div class="agenda-form-row">
                        <div class="agenda-form-group">
                            <label for="keterangan" class="agenda-label">Keterangan</label>
                            <textarea class="agenda-input readonly-field" name="keterangan" rows="2" readonly>{{ $agenda->description }}</textarea>
                        </div>
                        <div class="agenda-form-group">
                            <label for="status_reschedule" class="agenda-label">Status (Reschedule)</label>
                            <input type="text" class="agenda-input readonly-field" name="status_reschedule"
                                value="reschedule" readonly />
                        </div>
                    </div>
                    <div class="agenda-form-row">
                        <div class="agenda-form-group">
                            <label for="tanggal_reschedule" class="agenda-label">Tanggal Reschedule</label>
                            <input type="date" class="agenda-input" name="tanggal_reschedule"
                                value="{{ old('tanggal_reschedule', $agenda->date) }}" required />
                        </div>
                        <div class="agenda-form-group">
                            <label for="status" class="agenda-label">Status</label>
                            <select class="agenda-input" name="status" required>
                                <option value="draft" {{ $agenda->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="tentative" {{ $agenda->status == 'tentative' ? 'selected' : '' }}>Tentative
                                </option>
                                <option value="confirm" {{ $agenda->status == 'confirm' ? 'selected' : '' }}>Confirm
                                </option>
                                <option value="cancel" {{ $agenda->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
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
                .reschedule-title {
                    text-align: center;
                    font-size: 2.2rem;
                    font-weight: 700;
                    margin-top: 18px;
                    margin-bottom: 0.5rem;
                    letter-spacing: 1px;
                    color: #000;
                }

                .agenda-form-box.agenda-form-card {
                    width: 100%;
                    max-width: 100%;
                    background-color: #f8f9fa;
                    padding: 24px 32px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
                    margin: 0;
                }

                @media (max-width: 991.98px) {
                    .agenda-form-box.agenda-form-card {
                        padding: 16px 8px;
                    }
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

                .agenda-input.readonly-field[readonly] {
                    background-color: #dedede !important;
                    color: #000 !important;
                    cursor: not-allowed !important;
                    border: 1px solid #ced4da;
                }

                textarea.readonly-field[readonly] {
                    background-color: #dedede !important;
                    color: #000 !important;
                    cursor: not-allowed !important;
                    border: 1px solid #ced4da;
                }

                html[data-theme-active="tema4"] .agenda-input.readonly-field[readonly] {
                    background-color: #292929 !important;
                    color: #fff !important;
                    cursor: not-allowed !important;
                    border: 1px solid #ced4da;
                }

                html[data-theme-active="tema4"] textarea.readonly-field[readonly] {
                    background-color: #292929 !important;
                    color: #fff !important;
                    cursor: not-allowed !important;
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
