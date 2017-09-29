<div class="modal fade modal-default" id="activate-{{ $code->id }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Activate Code: {{ $code->code }}</h4>
            </div>
            <div class="modal-body">
                <p>Enter the ID number of the user buying</p>
                <form action="{{ route('admin_post_sell_activation') }}" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="id_number" class="form-control" placeholder="ID NUmber" required="" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="code_id" value="{{ $code->id }}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-primary">Activate</button>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
