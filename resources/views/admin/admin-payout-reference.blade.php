@extends('layouts.app')

@section('title') Payout Reference @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Payout Reference</h1>
			<hr>
			
			@include('includes.all')
			<!-- <button id="printbutton" onclick="printJS({printable: 'print-member', maxWidth: 1200, type: 'html', header: 'Member Payout'});" class="btn btn-primary"><i class="fa fa-print"></i> Print</button> -->

			<table class="table table-bordered" id="print-member">
				<thead>
					<tr>
						<th colspan="3" class="text-center">Member Info</th>
						<th colspan="2" class="text-center">Payment Reference</th>
						<th colspan="4"></th>
					</tr>
					<tr>
						<th>Auto Deducted</th>
						<th>Name</th>
						<th>Seller Account</th>
						<th>Code Sale</th>
						<th>Direct Ref. Bonus</th>
						<th>From</th>
						<th>Buyer Account</th>
						<th>Amount</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($reference as $r)
					<tr>
						<td>
							@if($r->autodeduct == 1)
								Yes
							@else
								No
							@endif
						</td>
						<td>{{ ucwords($r->seller->firstname . ' ' . $r->seller->lastname) }}</td>
						<td>
							@if(count($r->seller_account) > 0)
							{{ $r->seller_account->account_alias }}
							@else
							N/A
							@endif
						</td>
						<td>&#8369; {{ $r->sales }}</td>
						<td>&#8369; {{ $r->direct_referral }}</td>
						<td>{{ ucwords($r->buyer->firstname . ' ' . $r->buyer->lastname) }}</td>
						<td>
							@if(count($r->buyer_account) > 0)
							{{ $r->buyer_account->account_alias }}
							@else
							N/A
							@endif
						</td>
						<td><strong>&#8369; {{ $r->sales + $r->direct_referral }}</strong></td>
						<td>{{ date('M d, Y', strtotime($r->created_at)) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<p class="text-center"><strong>{{ $reference->count() + $reference->perPage() * ($reference->currentPage() - 1) }} of {{ $reference->total() }}</strong></p>

	        <!-- Page Number render() -->
	        <div class="text-center"> {{ $reference->links() }}</div>
		</section>

	</div>


</div>
@endsection