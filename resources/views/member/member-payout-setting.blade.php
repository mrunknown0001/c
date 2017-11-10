@extends('layouts.app')

@section('title') Member Payout Setting @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Current Payout Setting:: 
			@if(count($default) == 0)
			<i><u>Payout Not Set</u></i>
			@else
			{{ $default->mop }}
			@endif
			</h3>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_update_member_default_payout') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<select name="mode_of_payout" class="form-control">
								<option value="">Select Mode of Payout</option>
								@foreach($options as $opt)
								<option value="{{ $opt->name }}" @if($default->mop == $opt->name) selected @endif>{{ strtoupper($opt->name) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="name" class="form-control" value="{{ $default->name }}" placeholder="Full Name" />
						</div>
						<div class="form-group">
							<input type="text" name="bank" class="form-control" value="{{ $default->bank }}" placeholder="Bank Name" />
						</div>
						<div class="form-group">
							<input type="text" name="account_number" class="form-control" value="{{ $default->bank_account }}" placeholder="Account Number" />
						</div>
						<div class="form-group">
							<input type="text" name="contact_number" class="form-control" value="{{ $default->contact_number }}" placeholder="Contact Number" />
						</div>
						<div class="form-group">
							<input type="text" name="wallet_address" class="form-control" value="{{ $default->wallet_address }}" placeholder="Wallet Address" />
						</div>

						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Update Payout Details</button>
						</div>

					</form>
				</div>
			</div>
		</section>	
	</div>

</div>

@endsection