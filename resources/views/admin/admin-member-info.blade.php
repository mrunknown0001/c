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
								<th>Name:</th>
								<td>{{ ucwords($member->firstname . ' ' . $member->lastname) }}</td>
							</tr>
							<tr>
								<th>Username:</th>
								<td>{{ strtolower($member->username) }}</td>
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
								<th>Cash:</th>
								<td>&#8369; {{ $member->cash->total }}</td>
							</tr>
							<tr>
								<th>Balance:</th>
								<td>&#8369; {{ $member->member->balance->current }}</td>
							</tr>
							<tr>
								<th>Auto-Deduct:</th>
								<td>On/Off</td>
							</tr>
							<tr>
								<th>Downlines:</th>
								<td><i>List of Downlines</i></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection