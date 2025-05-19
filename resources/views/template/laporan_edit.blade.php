@extends('template.master')

@section('content')
<div class="container">
    <h2>Edit Status Laporan: {{ $laporan->ticket_number }}</h2>

    <form method="POST" action="{{ route('laporan.update', $laporan->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="open" {{ $laporan->status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ $laporan->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ $laporan->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('totalLaporan') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
