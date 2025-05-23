<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>Payment Successful</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>

                        <div class="mb-3">
                            <strong>Order ID:</strong> {{ $payment->order_id }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Transaction ID:</strong> {{ $payment->transaction_id }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Amount:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Payment Type:</strong> {{ $payment->payment_type }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Status:</strong> 
                            <span class="badge bg-success">{{ ucfirst($payment->status) }}</span>
                        </div>

                        <div class="d-grid mt-4">
                            <a href="{{ route('user.payments.index') }}" class="btn btn-primary">Make Another Payment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>