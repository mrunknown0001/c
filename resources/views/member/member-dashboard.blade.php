@extends('layouts.app')

@section('title') Member Dashboard @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Dashboard</h3>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					@if($balance->current != 0)
					<h1 style="color:red;">My Balance: &#8369; {{ $balance->current }}</h1>
					<p><em>If you already sent/deposited payment. Click <a href="{{ route('member_payment_send') }}">here</a></em></p>
					@endif
					<hr>
					<table class="table">
						<tr>
							<td>Name:</td>
							<td>{{ ucwords(Auth::user()->firstname . ' ' . Auth::user()->lastname) }}</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td>{{ Auth::user()->email }}</td>
						</tr>
						<tr>
							<td>Mobile:</td>
							<td>{{ Auth::user()->mobile }}</td>
						</tr>
						<tr>
							<td>Address:</td>
							<td>{{ ucwords(Auth::user()->address) }}</td>
						</tr>
					</table>
					<a href="{{ route('member_profile_update') }}" class="btn btn-primary btn-xs">Update My Profile</a>
					<a href="{{ route('member_password_change') }}" class="btn btn-warning btn-xs">Change Password</a>
					<a href="{{ route('member_profile_picture_change') }}" class="btn btn-info btn-xs">Change Profile Picture</a>
				</div>
			</div>
		</section>

	</div>

</div>
@endsection