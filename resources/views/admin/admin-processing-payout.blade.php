@extends('layouts.app')

@section('title') Processing Payout @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Processing Payout: <span class="text-danger">{{ count($payouts) }}</span></h1>
			<hr>
			
			@include('includes.all')
			<button id="printbutton" onclick="window.print();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>

			<table class="table">
				<thead>
					<tr>
						<th>Member</th>
						<th>Amount</th>
						<th>Thru</th>
					</tr>
				</thead>
				<tbody>
					@foreach($payouts as $p)
					<tr>
						<td>{{ ucwords($p->member->user->firstname . ' ' . $p->member->user->lastname) }}</td>
						<td>&#8369; {{ $p->amount }}</td>
						<td>{{ strtoupper($p->sent_thru) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<a href="{{ route('admin_mark_payout_success') }}" class="btn btn-primary">Mark All As Paid</a>
			<hr>
			<p><i>Note: Marking As Paid Action can't be undone. Make sure all transactions are paid before clicking <span class="btn btn-primary btn-xs">Mark All As Paid</span> button.</i></p>
		</section>

	</div>


</div>
@endsection