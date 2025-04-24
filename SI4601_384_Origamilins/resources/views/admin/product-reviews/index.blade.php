@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ulasan Produk</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Nama Pengguna</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('admin.product-reviews.show', $review) }}">
                                        {{ $review->produk->nama }}
                                    </a>
                                </td>
                                <td>
                                    @if($review->user)
                                        {{ $review->user->name }}
                                    @else
                                        <span class="text-muted">(User tidak tersedia)</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                                <td>
                                    @if($review->komentar)
                                        {{ Str::limit($review->komentar, 50) }}
                                    @else
                                        <span class="text-muted">(Tidak ada komentar)</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($review->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Disetujui</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $review->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.product-reviews.show', $review) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                        @if($review->status === 'pending')
                                            <form action="{{ route('admin.product-reviews.approve', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.product-reviews.reject', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted mb-0">Belum ada data ulasan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Menampilkan {{ $reviews->firstItem() }}-{{ $reviews->lastItem() }} dari {{ $reviews->total() }} ulasan
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        @if ($reviews->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $reviews->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        @foreach ($reviews->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $reviews->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        @if ($reviews->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $reviews->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        vertical-align: middle;
    }
    .text-warning {
        color: #ffc107 !important;
    }
    .pagination {
        margin-bottom: 0;
    }
    .page-link {
        color: #0835d8;
    }
    .page-item.active .page-link {
        background-color: #0835d8;
        border-color: #0835d8;
    }
    .btn-group {
        gap: 0.25rem;
    }
</style>
@endpush
@endsection 