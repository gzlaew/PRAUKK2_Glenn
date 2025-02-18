@extends('layouts.app')
{{-- Atau layout lain sesuai Jetstream: resources/views/layouts/app.blade.php, dsb --}}

@section('content')
<div class="container my-4">

    {{-- Jika roles Admin, tampilkan tombol 'Tambah Users' --}}
    @if(Auth::user()->role === 'Admin')

        <div class="mb-3">
            <a href="{{ route('users.create') }}">Tambah User</a>
        </div>
    @endif

    {{-- Tabel Daftar Users --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Roles</th>
                    @if(Auth::user()->role === 'Admin')

                        <th>Option</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>

                    @if(Auth::user()->role === 'Admin')

                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}"
                                  method="POST"
                                  style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Data users belum tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
