@extends('user.app')
@section('content')
<div class="container py-4">
    <h3 class="mb-4">Pesanan Saya</h3>
    @if($pesanan->isEmpty())
        <div class="text-center text-muted py-5">Belum ada pesanan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pesanan as $p)
                    <tr>
                        <td>{{ $p->id_pesanan }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $p->status }}</td>
                        <td>Rp{{ number_format($p->total,0,',','.') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Detail</a>
                            @if($p->status == 'Dikirim')
                                <form action="{{ route('user.pesanan.selesai', $p->id_pesanan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Pesanan Diterima</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection