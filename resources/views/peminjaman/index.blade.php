@extends('layouts.app')
@section('content')
<div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                  @if(in_array(Auth::user()->role, ['Admin','petugas', 'Supervisor']))
                    <h2>Table barang keluar <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">+ Tambah Data</a></h2>
                    <h2> <a href='user/laporan' class="btn btn-primary">laporan</a></h2>
                    @endif

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">


                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            @if (Session::has('success'))

        <div class="pt-20">
            <div class="alert-success">
                {{Session::get('success')}}
            </div>
        </div>


        @endif
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
                <th>detail</th>
                          </tr>
                        </thead>
                        @php
        $counter = 1; // Inisialisasi penghitung
    @endphp
    @foreach($peminjaman as $key => $p)

                        <tbody>
                          <tr class="even pointer">
                          <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>
                            <td>{{ $counter }}</td>
                            <td>{{ $p->kode_peminjaman }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->alat->nama }}</td>
                <td>{{ $p->jumlah }}</td>
                <td>{{ $p->tanggal_pengajuan }}</td>
                <td><span class="badge bg-info">{{ ucfirst($p->status) }}</span></td>
                <td>
                    <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
                <td>
        <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>
    </td>
                          </tr>

                        </tbody>
                        @php
            $counter++; // Increment penghitung
        @endphp
            @endforeach
                      </table>
                    </div>


                  </div>
                </div>
              </div>

@endsection
