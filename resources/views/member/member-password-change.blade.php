@extends('layouts.app')

@section('title') Password Change @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Password Change</h3>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_member_password_change') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<input type="password" name="old_password" class="form-control" placeholder="Enter Old Password" />
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Enter New Password" />
						</div>
						<div class="form-group">
							<input type="password" name="password_confirmation" class="form-control" placeholder="Re Enter New Password" />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Change Password</button>
							<a href="{{ route('member_dashboard') }}" class="btn btn-danger">Cancel</a>
						</div>

					</form>
				</div>
			</div>
		</section>
	</div>

</div>
@endsection