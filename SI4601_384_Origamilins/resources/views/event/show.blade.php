@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Event</h5>
                    <div>
                        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('events.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px">Nama Event</th>
                            <td>{{ $event->nama_event }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $event->deskripsi ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaksanaan</th>
                            <td>{{ date('d F Y', strtotime($event->tanggal_pelaksanaan)) }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $event->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                Hapus Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 