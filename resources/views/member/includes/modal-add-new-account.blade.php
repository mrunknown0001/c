<?php

    $accounts = \App\MemberAccount::where('user_id', Auth::user()->id)
                                ->orwhere('upline_account_id', Auth::user()->id)
                                ->orderBy('downline_level', 'asc')
                                ->get();

?>

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
                        <select name="upline" class="form-control">
                            <option value="">Select Upline Account</option>
                            @foreach($accounts as $account)
                            @if($account->downline_1 == null || $account->downline_2 == null || $account->downline_3 == null || $account->downline_4 == null || $account->downline_5 == null)
                            <option value="{{ $account->id }}">Downline Level: {{ $account->downline_level }} - {{ $account->account_alias }} ({{ $account->account_id }})</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
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
