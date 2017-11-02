<div class="modal fade modal-default" id="direct-{{ $ref->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Direct Referral Bonus Payment</h4>
            </div>
            <div class="modal-body">
                <h4>Sponsor: <u>{{ $ref->sponsor }}</u></h4>
                <form action="{{ route('post_admin_direct_referral_pay') }}" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="sponsor" class="form-control" placeholder="Enter Sponsor ID" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{ $ref->id }}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-primary">Pay</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
