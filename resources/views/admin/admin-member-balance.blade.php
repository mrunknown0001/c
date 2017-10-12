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
							@foreach($balances as $bal)
							<tr>
								<td>{{ $bal->uid }}</td>
								<td>{{ ucwords($bal->member->user->firstname . ' ' . $bal->member->user->lastname) }}</td>
								<td>&#8369; {{ $bal->current }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $balances->count() + $balances->perPage() * ($balances->currentPage() - 1) }} of {{ $balances->total() }}</strong></p>

		          <!-- Page Number render() -->
		          <div class="text-center"> {{ $balances->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection