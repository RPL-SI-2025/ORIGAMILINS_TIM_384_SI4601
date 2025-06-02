@extends('user.layouts.app')

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
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pesanan as $p)
                    <tr>
                        <td>{{ $p->id_pesanan }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            {{ $p->produk->nama_produk }}<br>
                            <small class="text-muted">{{ $p->jumlah }} unit</small>
                        </td>
                        <td>Rp{{ number_format($p->total_harga,0,',','.') }}</td>
                        <td>
                            <span class="badge {{ $p->status_pembayaran === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $p->status_pembayaran === 'Paid' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $p->status_badge }}">{{ $p->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('user.pesanan.show', $p->id_pesanan) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($p->status === 'Dikirim')
                                <form action="{{ route('user.pesanan.selesai', $p->id_pesanan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Pesanan Diterima
                                    </button>
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