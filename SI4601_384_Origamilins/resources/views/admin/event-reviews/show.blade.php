@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.event-reviews.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h2>{{ $event->nama_event }}</h2>
        <p class="text-muted">
            <i class="fas fa-calendar-alt"></i> {{ $event->tanggal_pelaksanaan->format('d M Y') }}
            <span class="mx-2">|</span>
            <i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}
        </p>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="display-4 mb-0">
                        {{ number_format($event->reviews->avg('rating'), 1) }}
                    </h3>
                    <div class="text-warning my-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($event->reviews->avg('rating')))
                                <i class="fas fa-star fa-lg"></i>
                            @else
                                <i class="far fa-star fa-lg"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="text-muted mb-0">{{ $event->reviews->count() }} ulasan</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Distribusi Rating</h5>
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $event->reviews->where('rating', $i)->count();
                            $percentage = $event->reviews->count() > 0 ? ($count / $event->reviews->count()) * 100 : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2" style="width: 70px">
                                @for($j = 1; $j <= 5; $j++)
                                    @if($j <= $i)
                                        <i class="fas fa-star small"></i>
                                    @else
                                        <i class="far fa-star small"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="progress flex-grow-1" style="height: 8px;">
                                <div class="progress-bar bg-warning" 
                                     role="progressbar" 
                                     style="width: {{ $percentage }}%" 
                                     aria-valuenow="{{ $percentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                            <span class="ms-2" style="width: 50px">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Ulasan</h5>
        </div>
        <div class="card-body">
            <div id="reviews-container">
                @include('admin.event-reviews._reviews_table')
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let page = 1;
    const container = document.getElementById('reviews-container');
    const loadMoreBtn = document.getElementById('load-more');

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            page++;
            fetch(`{{ route('admin.event-reviews.get-reviews', $event->id) }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.hasMorePages) {
                        loadMoreBtn.style.display = 'none';
                    }
                    container.innerHTML = data.html;
                });
        });
    }
});
</script>
@endpush
@endsection 