@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ulasan Event</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Nama Pengguna</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $review->event->nama_event }}</td>
                            <td>{{ $review->user->name }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </td>
                            <td>{{ Str::limit($review->komentar, 50) }}</td>
                            <td>
                                @if($review->status === 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($review->status === 'Disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $review->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.event-reviews.show', $review->id) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                    @if($review->status === 'Menunggu')
                                        <form action="{{ route('admin.event-reviews.approve', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.event-reviews.reject', $review->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada ulasan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Menampilkan {{ $reviews->firstItem() ?? 0 }}-{{ $reviews->lastItem() ?? 0 }} dari {{ $reviews->total() ?? 0 }} ulasan
                </div>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table td {
        vertical-align: middle;
        padding: 0.75rem;
    }
    .table th {
        padding: 0.75rem;
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.8em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    .gap-1 {
        gap: 0.25rem !important;
    }
    .d-flex {
        display: flex !important;
    }
</style>
@endpush
@endsection 