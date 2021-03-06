@extends('layouts.app')

@section('title') Admin Dashboard @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Dashboard</h1>
			<hr>
			<div class="row">
				<div class="col-md-4">
					@include('includes.all')
					<form action="{{ route('admin_member_search') }}" method="GET" autocomplete="off">
					    <div class="input-group">
					      <input type="text" name="keyword" class="form-control" placeholder="Search Name or ID Number">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="submit">Go!</button>
					      </span>
					    </div>
					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection