@extends('layouts.app')

@section('title') Member Profile Update @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Profile Update</h3>
			<div class="row">
				<div class="col-md-8">
					@include('includes.all')
					<form action="{{ route('post_member_profile_update') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<div class="form-group">
				  				<input type="text" name="firstname" class="form-control text-capitalize" value="{{ Auth::user()->firstname }}" placeholder="First Name" />
				  			</div>
				  			<div class="form-group">
				  				<input type="text" name="lastname" class="form-control text-capitalize" value="{{ Auth::user()->lastname }}" placeholder="Last Name" />
				  			</div>
				  			<div class="form-group">
				  				<input type="email" name="email" class="form-control text-lowercase" value="{{ Auth::user()->email }}" placeholder="Email" />
				  			</div>
				  			<div class="form-group">
				  				<input type="number" name="mobile_number" class="form-control" value="{{ Auth::user()->mobile }}" placeholder="Mobile Number" />
				  			</div>
				  			<div class="form-group">
				  				<input type="text" name="address" class="form-control text-capitalize" value="{{ Auth::user()->address }}" placeholder="Address" />
				  			</div>
				  			<div class="form-group">
				  				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				  				<button class="btn btn-primary">Update</button>
								<a href="{{ route('member_dashboard') }}" class="btn btn-danger">Cancel</a>
				  			</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>

</div>
@endsection