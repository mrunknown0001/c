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
				<div class="col-md-6">
					@include('includes.all')
					<form action="#">
					    <div class="input-group">
					      <input type="text" name="keyword" class="form-control" placeholder="Search">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="button">Go!</button>
					      </span>
					    </div>
					</form>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection