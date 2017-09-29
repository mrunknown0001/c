@extends('layouts.app')

@section('title') Admin Dashboard @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Dashboard</h1>
			<hr>
		</section>
		<div class="row">
			<div class="col-md-5 col-md-offset-1">
				<form action="#" class="form-inline">
					<div class="input-group">
						<input type="text" name="keyword" class="form-control" placeholder="Search..." />
						<button>Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>


</div>
@endsection