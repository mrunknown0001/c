@extends('layouts.app')

@section('title') Sell Codes @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Sell Codes</h1>
		</section>
		<div class="row">
			<div class="col-md-10">
				{{--  session messages --}}
				@include('includes.all')
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Codes</th>
							<th>Owner</th>
							<th>Used</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($codes as $code)
						<tr>
							<td>{{ strtoupper($code->code->code) }}</td>
							<td>
								{{ ucwords($code->owner->firstname) }} {{ ucwords($code->owner->lastname) }}
							</td>
							<td>
								{{ $code->usage }}
							</td>
							<td><button class="btn btn-primary btn-xs" >Option</button></td>
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