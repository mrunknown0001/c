@extends('layouts.app')

@section('title') Member Payout Request @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Request Payout</h3>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<form action="#">
						<div class="form-group">
							<select name="sent_thru" id="" class="form-control">
								<option value="">Select One</option>
								<option value="Coins.ph" selected="">Coins.ph</option>
								<option value="BDO">BDO Bank Deposit</option>
							</select>
						</div>
						<div class="form-group">
							<input type="number" name="amount" class="form-control" placeholder="Enter Amount" />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Send Request</button>
						</div>
					</form>
				</div>
			</div>
		</section>	
	</div>

</div>
@endsection