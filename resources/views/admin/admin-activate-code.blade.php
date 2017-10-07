@extends('layouts.app')

@section('title') Activate Codes @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Activate Codes</h1>
			{{--  session messages --}}
			@include('includes.all')
		</section>
		<div class="row">
			<div class="col-md-10">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Codes</th>
							<th>Active</th>
							<th>Used</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($codes as $code)
						<tr>
							<td>{{ strtoupper($code->code) }}</td>
							<td>
								@if($code->active == 0)
								No
								@else
								Yes
								@endif
							</td>
							<td>
								@if($code->used == 0)
								No
								@else
								Yes
								@endif
							</td>
							<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#activate-{{ $code->id }}">Activate</button></td>
						</tr>
						@include('admin.includes.modal-activate-sell-code')
						@endforeach
					</tbody>
				</table>
				<p class="text-center"><strong>{{ $codes->count() + $codes->perPage() * ($codes->currentPage() - 1) }} of {{ $codes->total() }}</strong></p>

	          <!-- Page Number render() -->
	          <div class="text-center"> {{ $codes->links() }}</div>
				</div>
		</div>
	</div>

</div>
@endsection