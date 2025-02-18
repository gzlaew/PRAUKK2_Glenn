@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Perusahaan</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $setting->name ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Alamat Perusahaan</label>
            <textarea name="address" id="address" class="form-control" rows="3" required>{{ $setting->address ?? '' }}</textarea>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telepon Perusahaan</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $setting->phone ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo Perusahaan</label>
            <input type="file" name="logo" id="logo" class="form-control">
            @if($setting && $setting->logo && file_exists(public_path('storage/' . $setting->logo)))
                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="img-fluid mt-2" style="max-width: 150px;">
            @else
                <p class="text-muted">Logo belum diunggah.</p>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
