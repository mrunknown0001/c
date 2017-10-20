@extends('layouts.app')

@section('title') System Settings @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>System Settings</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')
					<form action="{{ route('post_admin_admin_system_settings') }}" method="POST" autocomplete="off">
						<div class="form-group">
							<input type="text" name="system_name" value="{{ $setting->system_name }}" class="form-control" placeholder="System Name" />
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Update</button>
							<a href="{{ route('admin_dashboard') }}" class="btn btn-danger">Cancel</a>
						</div>
					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection