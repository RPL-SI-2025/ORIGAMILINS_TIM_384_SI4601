<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header 
                        @if($payment->status == 'success') bg-success text-white
                        @elseif($payment->status == 'failed') bg-danger text-white
                        @else bg-warning text-dark @endif">
                        <h4>Payment Status: {{ ucfirst($payment->status) }}</h4>
                    </div>
                    <div class="card-body">
                        @if($payment->status == 'success')
                            <div class="text-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </div>
                        @elseif($payment->status == 'failed')
                            <div class="text-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-x-circle-fill text-danger" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                            </div>
                        @else
                            <div class="text-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-hourglass-split text-warning" viewBox="0 0 16 16">
                                    <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong>Order ID:</strong> {{ $payment->order_id }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Transaction ID:</strong> {{ $payment->transaction_id ?? 'Not available' }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Amount:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Payment Type:</strong> {{ $payment->payment_type ?? 'Not available' }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Status:</strong> 
                            @if($payment->status == 'success')
                                <span class="badge bg-success">Success</span>
                            @elseif($payment->status == 'failed')
                                <span class="badge bg-danger">Failed</span>
                            @elseif($payment->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                            @endif
                        </div>

                        <div class="d-grid mt-4">
                            <a href="{{ route('user.payments.index') }}" class="btn btn-primary">Back to Payment Form</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>