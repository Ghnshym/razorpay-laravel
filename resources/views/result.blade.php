
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Details</div>

                <div class="card-body">
                    <p><strong>Payment ID:</strong> {{ $paymentRecord->r_payment_id }}</p>
                    <p><strong>Payment Method:</strong> {{ $paymentRecord->method }}</p>
                    <p><strong>Currency:</strong> {{ $paymentRecord->currency }}</p>
                    <p><strong>User Email:</strong> {{ $paymentRecord->user_email }}</p>
                    <p><strong>Amount:</strong> ${{ $paymentRecord->amount }}</p>
                    <!-- Add more fields as needed -->
                </div>
            </div>
        </div>
    </div>
</div>
