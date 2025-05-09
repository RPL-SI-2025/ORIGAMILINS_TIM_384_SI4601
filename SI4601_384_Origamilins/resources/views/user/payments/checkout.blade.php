<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Checkout</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Order ID:</strong> {{ $payment->order_id }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Name:</strong> {{ $payment->name }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Email:</strong> {{ $payment->email }}
                        </div>
                        
                        <div class="mb-3">
                            <strong>Amount:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </div>
                        
                        <div class="d-grid">
                            <button id="pay-button" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pay-button').onclick = function() {
            // Open Snap payment page when button is clicked
        snap.pay('{{ $payment->snap_token }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route('user.payments.finish', $payment->id) }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route('user.payments.finish', $payment->id) }}';
            },
            onError: function(result) {
                window.location.href = '{{ route('user.payments.finish', $payment->id) }}';
            },
            onClose: function() {
                alert('You closed the payment window without completing payment');
            }
        });
                };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>