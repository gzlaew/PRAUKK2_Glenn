@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Shift</h2>

    <!-- Tampilkan error jika ada -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shift.update', $shift->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="shift_date" class="form-label">Tanggal</label>
            <input type="date" name="shift_date" class="form-control" id="shift_date"
                   value="{{ old('shift_date', $shift->shift_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Pegawai</label>
            <select name="user_id" class="form-select" id="user_id" required>
                <!-- Loop user sesuai kebutuhan -->
                @foreach($users as $u)
                    <option value="{{ $u->id }}"
                        {{ $u->id == $shift->user_id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="hour" class="form-label">Jam Kerja</label>
            <select name="hour" class="form-select" id="hour" required>
                <option value="Shift Pagi 06:00-12:00"
                    {{ $shift->hour == 'Shift Pagi 06:00-12:00' ? 'selected' : '' }}>
                    Shift Pagi 06:00-12:00
                </option>
                <option value="Shift Siang 12:00-18:00"
                    {{ $shift->hour == 'Shift Siang 12:00-18:00' ? 'selected' : '' }}>
                    Shift Siang 12:00-18:00
                </option>
                <option value="Shift Malam 18:00-00:00"
                    {{ $shift->hour == 'Shift Malam 18:00-00:00' ? 'selected' : '' }}>
                    Shift Malam 18:00-00:00
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
