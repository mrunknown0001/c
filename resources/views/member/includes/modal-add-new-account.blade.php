<div class="modal fade modal-default" id="add-new-account" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Account</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('post_add_member_account') }}" method="POST" autocomplete="off">
                    <div class="form-group">
                        <!-- <input type="text" name="alias" class="form-control" placeholder="Account Alias" /> -->
                        <p><i>The Account Alias will automatically generate by the system.</i></p>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-primary">Add New Account</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>

    </div>
</div>
