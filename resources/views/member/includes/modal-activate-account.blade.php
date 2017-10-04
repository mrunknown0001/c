<div class="modal fade modal-default" id="acc-{{ $acc->account_alias }}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Activate Account: {{ $acc->account_alias }}</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('post_member_activate_account') }}" method="POST">
                    <div class="form-group">
                        <select name="code" id="" class="form-control">
                            <option value="">Select Sell Code</option>
                            @foreach($acc->member->codes as $c)
                            @if($c->usage > 4)
                            <option value="">No Code Available</option>
                            @else
                            <option value="{{ $c->code_id }}">{{ $c->code->code }} &nbsp; &nbsp; (Remaining: {{ 5 - $c->usage }})</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="account_id" value="{{ $acc->id }}" />
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
