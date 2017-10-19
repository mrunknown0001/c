<div class="modal fade modal-default" id="n-{{ $p->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Attachment: {{ $p->image_file }}</h4>
            </div>
            <div class="modal-body">
                <div>
                <img src="/uploads/payments/{{ $p->image_file }}" class="img-responsive" alt="Payment Attachment">
                </div>
                <hr>
               <p class="text-uppercase pull-left">
                    <b>{{ $p->sent_thru }}</b>
                    <br>
                    <b>{{ $p->description }}</b>
                </p>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
