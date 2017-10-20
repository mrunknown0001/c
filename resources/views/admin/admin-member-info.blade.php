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
								<td>Name:</td>
								<td>{{ ucwords($member->firstname . ' ' . $member->lastname) }}</td>
							</tr>
							<tr>
								<td>Username:</td>
								<td>{{ strtolower($member->username) }}</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>{{ strtolower($member->email) }}</td>
							</tr>
							<tr>
								<td>Mobile:</td>
								<td>{{ $member->mobile }}</td>
							</tr>
							<!-- <tr>
								<td>Address:</td>
								<td>{{ ucwords($member->address) }}</td>
							</tr> -->
							<tr>
								<td>Number of Accounts:</td>
								<td>{{ count($member->accounts) }}</td>
							</tr>
							<tr>
								<td>Cash:</td>
								<td></td>
							</tr>
							<tr>
								<td>Balance:</td>
								<td></td>
							</tr>
							<tr>
								<td>Auto-Deduct:</td>
								<td>On/Off</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection