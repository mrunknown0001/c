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
			<button id="printbutton" onclick="printJS({printable: 'print-member', maxWidth: 1200, type: 'html', header: 'Member Payout'});" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>

			<table class="table table-bordered" id="print-member">
				<thead>
					<tr>
						<th colspan="6" class="text-center">Member Info</th>
						<th colspan="7" class="text-center">Payment Reference</th>
					</tr>
					<tr>
						<th>Auto Deducted</th>
						<th>Name</th>
						<th>ID</th>
						<th>Payout Option</th>
						<th>Contact</th>
						<th>Payout Details</th>
						<th>Code Sale</th>
						<th>Direct Ref. Bonus</th>
						<th>From</th>
						<th>ID</th>
						<th>Amount</th>
						<th>Total</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($payouts as $p)
					<?php 
					$printed = 0;
					?>
					@foreach($reference as $r)
					@if($p->member_account == $r->uid)
					<tr>
						<td>
							@if($r->autodeduct == 1)
								Yes
							@else
								No
							@endif
						</td>
						<td>{{ ucwords($r->seller->firstname . ' ' . $r->seller->lastname) }}</td>
						<td>{{ $r->seller->uid }}</td>
						@if($printed == 0)
						<td rowspan="{{ count($reference->where('member_id', $p->member->user->id)) }}">
							{{ $r->seller->default_payout->mop }}
						</td>
						<td rowspan="{{ count($reference->where('member_id', $p->member->user->id)) }}">{{ $r->seller->mobile }}</td>
						<td rowspan="{{ count($reference->where('member_id', $p->member->user->id)) }}">
							@if($r->seller->default_payout->mop == 'Bank Deposit')
							{{ ucwords($r->seller->default_payout->name) }} / 
							{{ strtoupper($r->seller->default_payout->bank) }} / 
							{{ $r->seller->default_payout->bank_account }}
							@elseif($r->seller->default_payout->mop == 'Coins.ph')
							{{ $r->seller->default_payout->wallet_address }}
							@elseif($r->seller->default_payout->mop == 'Cebuana')
							{{ ucwords($r->seller->default_payout->name) }}
							@elseif($r->seller->default_payout->mop == 'Security Bank eCash')
							N/A
							@else
							N/A
							@endif

						</td>
						@endif
						<td>{{ $r->sales }}</td>
						<td>{{ $r->direct_referral }}</td>
						<td>{{ ucwords($r->buyer->firstname . ' ' . $r->seller->lastname) }}</td>
						<td>{{ $r->buyer->uid }}</td>
						<td>{{ $r->sales + $r->direct_referral }}</td>
						@if($printed == 0)
						<td rowspan="{{ count($reference->where('member_id', $p->member->user->id)) }}">{{ $p->amount }}</td>
						@endif
						<td>{{ date('M d, Y', strtotime($r->created_at)) }}</td>
					</tr>
					@endif
					<?php
					$printed = 1;
					?>
					@endforeach
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