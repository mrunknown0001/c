@extends('layouts.app')

@section('title') Member Payout Setting @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Current Payout Setting:: <i>default payout setting</i></h3>
			<hr>
			<div class="row">
				<div class="col-md-6">
					<form action="#" method="POST" autocomplete="off">
						<div class="form-group">
							<select name="mode_of_payment" class="form-control">
								<option>Select Mode of Payment</option>
							</select>
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Update Payout MOP</button>
						</div>

					</form>
				</div>
			</div>
		</section>	
	</div>

</div>
@endsection