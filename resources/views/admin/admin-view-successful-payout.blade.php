@extends('layouts.app')

@section('title') Successful Payout @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Successful Payout</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					@include('includes.all')

					<form action="{{ route('admin_post_search_successful_payout') }}" method="POST" class="form-inline" autocomplete="off">
						<div class="form-group">
							<input type="date" name="date" required="" />
							{{ csrf_field() }}
							<button>Search Payout</button>
						</div>
					</form>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Requested Member</th>
								<th>Payout Via</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Date Payed</th>
							</tr>
						</thead>
						<tbody>
							@foreach($payouts as $p)
							<tr>
								<td>{{ ucwords($p->member->user->firstname . ' ' . $p->member->user->lastname) }} ({{ $p->user }})</td>
								<td>{{ strtoupper($p->sent_thru) }}</td>
								<td>{{ $p->amount }}</td>
								<td>
									<span class="btn btn-success btn-xs">Paid</span>
								</td>
								<td>{{ date('F d, Y', strtotime($p->updated_at)) }}</td>
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