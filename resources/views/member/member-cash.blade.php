@extends('layouts.app')

@section('title') Member Cash @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>My Cash</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Activation Code Sales</div>
						<div class="panel-body">
							<p class="text-center">&#8369; {{ $cash->total }}</p>
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Direct Referral Earnings</div>
						<div class="panel-body">
							<p class="text-center">&#8369; {{ $cash->direct_referral }}</p>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Pending Payout Cash</div>
						<div class="panel-body">
							<p class="text-center">&#8369; {{ $cash->pending }}</p>
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Excess Payment</div>
						<div class="panel-body">
							<p class="text-center">&#8369; {{ $cash->advance_payment }}</p>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">Total Withdrawable Cash</div>
						<div class="panel-body">
							<p class="text-center">&#8369; {{ $cash->total + $cash->direct_referral }}</p>
						</div>
					</div>	
				</div>
				<div class="col-md-6">
					<table class="table">
						<thead>
							<tr>
								<th>Cash In Days</th>
								<th>Cut Off</th>
								<th>Payout Day</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Monday to Wednesday</td>
								<td>Wednesday 11:59pm</td>
								<td>Friday</td>
							</tr>
							<tr>
								<td>Thursday to Sunday</td>
								<td>Sunday 11:59pm</td>
								<td>Tuesday</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>

</div>
@endsection