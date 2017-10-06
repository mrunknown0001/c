@extends('layouts.app')

@section('title') Payment Review @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Payment Review</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Attachment</th>
								<th>Verifacation Status</th>
								<th>Name</th>
								<th>Email Address</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pending_payments as $payment)
							<tr>
								<td><button class="btn btn-primary btn-xs">View Attachent</button></td>
								<td></td>
								<td>{{ ucwords($payment->payee->user->firstname . ' ' . $payment->payee->user->lastname) }}</td>
								<td></td>
								<td></td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $pending_payments->count() + $pending_payments->perPage() * ($pending_payments->currentPage() - 1) }} of {{ $pending_payments->total() }}</strong></p>

		          <!-- Page Number render() -->
		          <div class="text-center"> {{ $pending_payments->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection