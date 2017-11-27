@extends('layouts.app')

@section('title') Member Info @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Member: {{ $member->uid }}</h1>
			<hr>
			<a href="{{ route('admin_get_members') }}">Back to Members...</a>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<table class="table table-hover">
						<tbody>
							<tr>
								<td rowspan="4" class="text-center">
									@if($member->avatar->file == 0)
							        <img src="{{ URL::asset('uploads/avatar/default.jpg') }}" class="img-circle" alt="Member Image">
							        @else
							        <img src="{{ URL::asset('uploads/avatar/files/' . $member->avatar->file) }}" class="img-circle" alt="Member Image" height="100" width="">
							        @endif
								</td>
							</tr>
							<tr>
								<td>{{ ucwords($member->firstname . ' ' . $member->lastname) }}</td>
							</tr>
							<tr>
								<td><strong>ID:</strong> {{ $member->uid }}</td>
							</tr>
							<tr>
								<td><strong>Username:</strong> {{ strtolower($member->username) }}</td>
							</tr>
							<tr>
								<th>Email:</th>
								<td>{{ strtolower($member->email) }}</td>
							</tr>
							<tr>
								<th>Mobile:</th>
								<td>{{ $member->mobile }}</td>
							</tr>
							<!-- <tr>
								<td>Address:</td>
								<td>{{ ucwords($member->address) }}</td>
							</tr> -->
							<tr>
								<th>Number of Accounts:</th>
								<td>{{ count($member->accounts) }}</td>
							</tr>
							<tr>
								<th>No. of Sell Codes:</th>
								<td>{{ $member->codes->where('usage', 0)->count() }}</td>
							</tr>
							<tr>
								<th>Cash:</th>
								<td>&#8369; {{ $member->cash->total }}</td>
							</tr>
							<tr>
								<th>Direct Referral:</th>
								<td>&#8369; {{ $member->cash->direct_referral }}</td>
							</tr>
							<tr>
								<th>Pending Cashout:</th>
								<td>&#8369; {{ $member->cash->pending }}</td>
							</tr>
							<tr>
								<th>Balance:</th>
								<td>&#8369; {{ $member->member->balance->current }}</td>
							</tr>
							<tr>
								<th>Auto-Deduct:</th>
								<td>
									@if($member->autodeduct->status == 0)
									<button class="btn btn-danger btn-xs">OFF</button>
									@else
									<button class="btn btn-success btn-xs">ON</button>
									@endif
								</td>
							</tr>
							<tr>
								<th>Default Payout:</th>
								<td>
									@if(count($member->default_payout)  > 0)
										{{ strtoupper($member->default_payout->mop) }}
									@else
										Not Set
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection