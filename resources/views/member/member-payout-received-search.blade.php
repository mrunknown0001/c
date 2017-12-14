@extends('layouts.app')

@section('title') Member Payout Received @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Received Payouts Search Result: {{ count($payouts) }}</h3>
			@include('includes.all')
			<form class="form-inline" action="{{ route('member_post_payout_search') }}" method="POST" autocomplete="off">
				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="date" name="date" required="" />
					<button>Search Payout</button>
				</div>
			</form>
		</section>
			<div class="row">
				<div class="col-md-10">
				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Deposit Thru</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Date </th>
						</tr>
					</thead>
					<tbody>
						@foreach($payouts as $p)
						<tr>
							<td>{{ $p->sent_thru }}</td>
							<td>&#8369; {{ $p->amount }}</td>
							<td><span class="btn btn-success btn-xs">Paid</span></td>
							<td>{{ date('F d, Y', strtotime($p->created_at)) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<p class="text-center"><strong>{{ $payouts->count() + $payouts->perPage() * ($payouts->currentPage() - 1) }} of {{ $payouts->total() }}</strong></p>

		          <!-- Page Number render() -->
		          <div class="text-center"> {{ $payouts->links() }}</div>
				</div>
			</div>
	</div>

</div>
@endsection