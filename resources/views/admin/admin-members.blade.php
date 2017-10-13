@extends('layouts.app')

@section('title') Members @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>{{ $members->count() }} Total Members</h3>
			<form action="" class="form-inline">
			    <div class="input-group">
			      <input type="text" name="keyword" class="form-control" placeholder="Search">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button">Go!</button>
			      </span>
			    </div>
			</form>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</section>
	</div>

</div>
@endsection