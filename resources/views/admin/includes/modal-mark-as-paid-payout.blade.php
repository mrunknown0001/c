<div class="modal fade modal-default" id="map-{{ $p->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mark Payout as Paid</h4>
            </div>
            <div class="modal-body">
                <p>Enter Remark for <strong>{{ ucwords($p->member->user->firstname . ' ' . $p->member->user->lastname) }}</strong></p>
                <form action="#" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="remark" class="form-control" placeholder="Payout Remark" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-primary">Continue to mark as paid</button>
                    </div>
                </form>
                
                
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
