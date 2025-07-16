@extends('layouts.app', ['pageTitle' => 'Edit Agenda'])

@section('title', 'Edit Agenda')

@section('content')
    <div class="container mt-4"
        style="max-width: 600px; background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 class="mb-4 text-center fw-bold">Edit Agenda</h2>

        <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Penting untuk memberitahu Laravel ini adalah metode UPDATE --}}

            <div class="mb-3">
                <label for="date" class="form-label fw-bold">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $agenda->date }}" required>
            </div>

            <div class="mb-3">
                <label for="jam" class="form-label fw-bold">Jam</label>
                <input type="time" name="jam" id="jam" class="form-control" value="{{ $agenda->jam }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label fw-bold">Kegiatan</label>
                <textarea name="title" id="title" class="form-control" rows="2" required>{{ $agenda->title }}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Keterangan</label>
                <textarea name="description" id="description" class="form-control" rows="2" required>{{ $agenda->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="tempat" class="form-label fw-bold">Tempat</label>
                <input type="text" name="tempat" id="tempat" class="form-control" value="{{ $agenda->tempat }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="disposition" class="form-label fw-bold">Disposisi</label>
                <input type="text" name="disposition" id="disposition" class="form-control"
                    value="{{ $agenda->disposition }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fw-bold">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="draft" {{ $agenda->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="tentative" {{ $agenda->status == 'tentative' ? 'selected' : '' }}>Tentative</option>
                    <option value="confirm" {{ $agenda->status == 'confirm' ? 'selected' : '' }}>Confirm</option>
                    <option value="cancel" {{ $agenda->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                </select>
            </div>

            <button type="submit" class="btn btn-danger w-100">Simpan Perubahan</button>
            <a href="{{ route('agenda.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
@endsection
