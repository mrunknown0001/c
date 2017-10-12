@extends('layouts.app')

@section('title') Member Balance @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Member Balance</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Member ID</th>
								<th>Member Name</th>
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection