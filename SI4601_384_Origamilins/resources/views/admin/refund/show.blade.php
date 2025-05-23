@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>Detail Refund</h1>
        <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Informasi Transaksi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="200">ID Transaksi</th>
                            <td>{{ $payment->order_id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pengguna</th>
                            <td>{{ $payment->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ $payment->payment_type ?? 'Belum dipilih' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($payment->status == 'refund_requested')
                                    <span class="badge bg-warning text-dark">Menunggu Refund</span>
                                @elseif($payment->status == 'refunded')
                                    <span class="badge bg-success">Refund Diterima</span>
                                @elseif($payment->status == 'refund_rejected')
                                    <span class="badge bg-danger">Refund Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Refund
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Permintaan Refund
                                    <span class="text-muted">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                                </li>
                                @if($payment->refunded_at)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Refund Diproses
                                    <span class="text-muted">{{ $payment->refunded_at->format('d/m/Y H:i') }}</span>
                                </li>
                                @endif
                                @if($payment->refund_rejected_at)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Refund Ditolak
                                    <span class="text-muted">{{ $payment->refund_rejected_at->format('d/m/Y H:i') }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    @if($payment->refund_reason)
                    <div class="card mt-3">
                        <div class="card-header">
                            <i class="fas fa-comment me-1"></i>
                            Alasan Refund
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $payment->refund_reason }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($payment->status == 'refund_requested')
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#processRefundModal">
                            <i class="fas fa-check"></i> Proses Refund
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectRefundModal">
                            <i class="fas fa-times"></i> Tolak Refund
                        </button>
                    </div>
                </div>
            </div>

            <!-- Process Refund Modal -->
            <div class="modal fade" id="processRefundModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.refunds.process', $payment->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Proses Refund</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin memproses refund untuk transaksi ini?</p>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Alasan Refund</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Proses Refund</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reject Refund Modal -->
            <div class="modal fade" id="rejectRefundModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.refunds.reject', $payment->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Tolak Refund</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menolak permintaan refund ini?</p>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Alasan Penolakan</label>
                                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Refund</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 