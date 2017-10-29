@extends('layouts.app')

@section('title') Admin Update Payou Option @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Update Payou Option</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_update_payout_option') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<input type="text" name="name" value="{{ $option->name }}" class="form-control text-capitalize" placeholder="Name..." />
						</div>
						<div class="form-group">
							<input type="text" name="description" value="{{ $option->description }}" class="form-control text-capitalize" placeholder="Short Description..." />
						</div>
						<div class="form-group">
							<input type="hidden" name="id" value="{{ $option->id }}" />
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Update Payment Option</button>
							<a href="{{ route('admin_payout_options') }}" class="btn btn-danger">Cancel</a>
						</div>

					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection