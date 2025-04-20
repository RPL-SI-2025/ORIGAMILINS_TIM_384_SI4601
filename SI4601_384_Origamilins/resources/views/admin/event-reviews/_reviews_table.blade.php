@if($reviews->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
        <p class="h5 text-muted">Belum ada ulasan untuk event ini</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                    <tr>
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
                                {{ $review->komentar }}
                            @else
                                <span class="text-muted">(Tidak ada komentar)</span>
                            @endif
                        </td>
                        <td>{{ $review->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            Menampilkan {{ $reviews->firstItem() }}-{{ $reviews->lastItem() }} dari {{ $reviews->total() }} ulasan
        </div>
        @if($reviews->hasMorePages())
            <button id="load-more" class="btn btn-primary">
                Muat Lebih Banyak
            </button>
        @endif
    </div>
@endif 