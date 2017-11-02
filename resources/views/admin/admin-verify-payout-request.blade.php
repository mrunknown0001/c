@extends('layouts.app')

@section('title') Payout Requests @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Payout Requests</h1>
			<hr>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Requested Member</th>
								<th>Payout Via</th>
								<th>Amount</th>
								<th>Date of Request</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($payouts as $p)
							<tr>
								<td>{{ ucwords($p->member->user->firstname . ' ' . $p->member->user->lastname) }} ({{ $p->user }})</td>
								<td>{{ ucwords($p->sent_thru) }}</td>
								<td>{{ $p->amount }}</td>
								<td>{{ date('F d, Y H:i:s A', strtotime($p->created_at)) }}</td>
								<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#map-{{ $p->id }}">Mark as Paid</button></td>
							</tr>
							@include('admin.includes.modal-mark-as-paid-payout')
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $payouts->count() + $payouts->perPage() * ($payouts->currentPage() - 1) }} of {{ $payouts->total() }}</strong></p>

			        <!-- Page Number render() -->
			        <div class="text-center"> {{ $payouts->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection