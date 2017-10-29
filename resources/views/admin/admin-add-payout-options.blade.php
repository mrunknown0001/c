@extends('layouts.app')

@section('title') Admin Add Payout Option @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Add Payout Option</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_add_payout_option') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<input type="text" name="name" class="form-control text-capitalize" placeholder="Name..." />
						</div>
						<div class="form-group">
							<input type="text" name="description" class="form-control text-capitalize" placeholder="Short Description..." />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Add Payout Option</button>
							<a href="{{ route('admin_payout_options') }}" class="btn btn-warning">Payout Option Lists</a>
						</div>

					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection