@extends('layouts.app')

@section('title') Admin Add Payment Option @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Add Payment Option</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_add_payment_option') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<input type="text" name="name" class="form-control text-capitalize" placeholder="Name..." />
						</div>
						<div class="form-group">
							<input type="text" name="description" class="form-control text-capitalize" placeholder="Short Description..." />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Add Payment Option</button>
							<a href="{{ route('admin_payment_options') }}" class="btn btn-warning">Payment Option Lists</a>
						</div>

					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection