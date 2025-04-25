@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Ulasan Event</h2>
        <a href="{{ route('admin.event-reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Ulasan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px">Event</th>
                            <td>
                                <a href="{{ route('admin.event.show', $review->event->id) }}" class="text-primary">
                                    {{ $review->event->nama_event }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Pengguna</th>
                            <td>{{ $review->user->name }}</td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </td>
                        </tr>
                        <tr>
                            <th>Komentar</th>
                            <td>{{ $review->komentar }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($review->status === 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($review->status === 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $review->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>

                    @if($review->status === 'Menunggu')
                        <div class="mt-4">
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.event-reviews.approve', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Setujui Ulasan
                                    </button>
                                </form>
                                <form action="{{ route('admin.event-reviews.reject', $review->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Tolak Ulasan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Event</h5>
                    <div class="text-center mb-3">
                        @if($review->event->poster)
                            <img src="{{ asset($review->event->poster) }}" alt="{{ $review->event->nama_event }}" class="img-fluid rounded" style="max-height: 200px;">
                        @else
                            <div class="bg-light rounded p-5 text-center">
                                <i class="fas fa-calendar fa-3x text-muted"></i>
                                <p class="mt-2 text-muted">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 100px">Nama Event</th>
                            <td>{{ $review->event->nama_event }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $review->event->tanggal_pelaksanaan->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $review->event->lokasi }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-title {
        color: #333;
        font-weight: 600;
    }
    .table th {
        font-weight: 600;
        color: #555;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    .btn {
        padding: 0.5rem 1rem;
    }
    .gap-2 {
        gap: 0.5rem !important;
    }
</style>
@endpush
@endsection 