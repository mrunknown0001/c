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
					<form action="{{ route('post_update_member_default_payout') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<select name="mode_of_payment" class="form-control">
								<option>Select Mode of Payout</option>
								@foreach($options as $opt)
								<option value="{{ $opt->name }}">{{ strtoupper($opt->name) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							coins.ph
						</div>
						<div class="form-group">
							cebuana
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