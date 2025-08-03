@extends('layouts.app', ['pageTitle' => 'Edit Agenda'])

@section('title', 'Edit Agenda')

@section('content')
    <h2 class="edit-agenda-title">Edit Agenda</h2>
    <section class="content mt-4">
        <div class="container-fluid px-0">
            <div class="agenda-form-box agenda-form-card w-100" style="max-width:100%;">
                <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ $agenda->date }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="jam" class="form-label fw-bold">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control"
                                value="{{ $agenda->jam }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-bold">Kegiatan</label>
                            <textarea name="title" id="title" class="form-control" rows="2" required>{{ $agenda->title }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="description" class="form-label fw-bold">Keterangan</label>
                            <textarea name="description" id="description" class="form-control" rows="2" required style="margin-top:0;">{{ $agenda->description }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="tempat" class="form-label fw-bold">Tempat</label>
                            <input type="text" name="tempat" id="tempat" class="form-control"
                                value="{{ $agenda->tempat }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="disposition" class="form-label fw-bold">Disposisi</label>
                            <input type="text" name="disposition" id="disposition" class="form-control"
                                value="{{ $agenda->disposition }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ $agenda->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="tentative" {{ $agenda->status == 'tentative' ? 'selected' : '' }}>Tentative
                                </option>
                                <option value="confirm" {{ $agenda->status == 'confirm' ? 'selected' : '' }}>Confirm
                                </option>
                                <option value="cancel" {{ $agenda->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-danger px-4">Simpan Perubahan</button>
                        <a href="{{ route('agenda.index') }}" class="btn btn-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        @endsection

        @push('styles')
            <style>
                .edit-agenda-title {
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

                html[data-theme-active="tema4"] .container.mt-4 {
                    background-color: var(--primary) !important;
                    color: #fff !important;
                    box-shadow: 0 2px 8px rgba(19, 15, 45, 0.18);
                }

                html[data-theme-active="tema4"] .container.mt-4 .form-control,
                html[data-theme-active="tema4"] .container.mt-4 .form-select,
                html[data-theme-active="tema4"] .container.mt-4 textarea {
                    background-color: var(--tertiary) !important;
                    color: #fff !important;
                    border: 1px solid #383187 !important;
                }

                html[data-theme-active="tema4"] .container.mt-4 label,
                html[data-theme-active="tema4"] .container.mt-4 h2 {
                    color: #fff !important;
                }

                html[data-theme-active="tema4"] .form-control[type="date"]::-webkit-calendar-picker-indicator,
                html[data-theme-active="tema4"] .form-control[type="time"]::-webkit-calendar-picker-indicator {
                    filter: invert(38%) sepia(98%) saturate(1200%) hue-rotate(180deg) brightness(1.1);
                }
            </style>
        @endpush
