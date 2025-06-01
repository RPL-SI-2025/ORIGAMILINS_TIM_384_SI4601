@extends('user.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Notifikasi</h3>
    @if($notifications->isEmpty())
        <div class="text-center text-muted py-5">Tidak ada notifikasi baru.</div>
    @else
        <ul class="list-group">
            @foreach($notifications as $notif)
                <li class="list-group-item d-flex justify-content-between align-items-start {{ $notif->is_read ? '' : 'bg-light' }}">
                    <div>
                        <div class="fw-bold">{{ $notif->title }}</div>
                        <div class="small text-muted">{{ $notif->created_at->diffForHumans() }}</div>
                        <div>{{ $notif->message }}</div>
                    </div>
                    @if(!$notif->is_read)
                        <form action="{{ route('user.notifikasi.read', $notif->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary">Tandai Dibaca</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection