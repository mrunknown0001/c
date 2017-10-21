@extends('layouts.app')

@section('title') Member Payout Pending @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Pending Payouts</h3>
			<div class="row">
				<div class="col-md-10">
				@include('includes.all')
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Deposit Thru</th>
							<th>Amount</th>
							<th>Status</th>
							<th>Date Request</th>
						</tr>
					</thead>
					<tbody>
						@foreach($payouts as $p)
						<tr>
							<td>{{ $p->sent_thru }}</td>
							<td>&#8369; {{ $p->amount }}</td>
							<td><i>Pending</i></td>
							<td>{{ date('F d, Y H:i:s', strtotime($p->created_at)) }}</td>
						</tr>
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