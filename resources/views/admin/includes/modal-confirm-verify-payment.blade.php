<div class="modal fade modal-default" id="v-{{ $payment->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm Verify Payment</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('post_payment_verify') }}" method="POST" autocomplete="off">
                    <div class="form-group">
                        Payee: <strong>{{ ucwords($payment->payee->user->firstname . ' ' . $payment->payee->user->lastname) }}</strong>. Click Verify Payment to continue...
                    </div>
                    <!-- <div class="form-group">
                        <input type="number" name="count" class="form-control" value=0 placeholder="# of Code Paid" />
                    </div> -->
                    <div class="form-group">
                        <input type="number" name="amount" class="form-control" placeholder="Verified Ammount" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="payment_id" value="{{ $payment->id }}" />
                        <input type="hidden" name="member_id" value="{{ $payment->payee->user->id }}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-success">Verify Payment</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
