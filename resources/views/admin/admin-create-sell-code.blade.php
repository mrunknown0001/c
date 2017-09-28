@extends('layouts.app')

@section('title') Create Sell Code @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Create Sell Code</h1>
		</section>

		<hr>

		<div class="col-md-6">
			<form action="{{ route('post_admin_create_sell_code') }}">
				<div class="form-group">
					<p>Number of Code to Create</p>
					<input type="number" name="number" class="form-control" placeholder="Number Codes: 1~20" max=20 min=1 />
				</div>
				<div class="form-group">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<button class="btn btn-primary btn-lg">Create Sell Code</button>
				</div>
			</form>
		</div>
	</div>

</div>
@endsection