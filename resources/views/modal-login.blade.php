<div class="modal fade modal-success" id="modal-login" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <div class="pull-left">CLLR Trading Member Login</div>
                <div class="pull-right"><button type="button" class="close pull-right" data-dismiss="modal">&times;</button></div>
            </div>
            <div class="modal-body">
                <form action="{{ route('post_login') }}" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="User ID" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <button class="btn btn-primary">Login</button>
                        <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                <p>Don't have an account? Click <a href="javascript:void();" data-toggle="modal" data-target="#modal-register">here</a>.</p>
                <p><a href="#">Forgot Password?</a></p>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>

    </div>
</div>
