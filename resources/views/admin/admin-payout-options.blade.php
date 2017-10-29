@extends('layouts.app')

@section('title') Payout Options @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>{{ $options->count() }} Payout Options</h1>
			<hr>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					<a href="{{ route('add_payout_option') }}" class="btn btn-primary btn-xs">Add Payout Option</a>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Payout Name</th>
								<th>Short Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($options as $option)
							<tr>
								<td>{{ strtoupper($option->name) }}</td>
								<td>{{ ucwords($option->description) }}</td>
								<td>
									<a href="{{ route('admin_update_payout_option', ['name' => $option->name]) }}" class="btn btn-primary btn-xs">Edit</a>
									<a href="{{ route('admin_remove_payout_option', ['name' => $option->name]) }}" class="btn btn-danger btn-xs">Remove</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection