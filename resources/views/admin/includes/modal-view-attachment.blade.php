<div class="modal fade modal-default" id="n-{{ $payment->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Attachment: {{ $payment->image_file }}</h4>
            </div>
            <div class="modal-body">
                <img src="/uploads/payments/{{ $payment->image_file }}" class="img-responsive" alt="Payment Attachment">
                <div>
                    <p class="text-capitalize">{{ $payment->description }}</p>
                </div>
                
            </div>
<!--             <div class="modal-footer">

            </div> -->
        </div>

    </div>
</div>
