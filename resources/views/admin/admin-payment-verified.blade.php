@extends('layouts.app')

@section('title') Verified Successful Payment @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Verified Successful Payment</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Attachment</th>
								<th>Status</th>
								<th>Name</th>
								<th>Email</th>
								<th>Date of Send</th>
								<th>Date of Verify</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($verified_payments as $payment)
							<tr>
								<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#n-{{ $payment->id }}">View Attachent</button></td>
								<td>
									@if($payment->status == 0)
										Unverified
									@else
										<button class="btn btn-success btn-xs">Verified</button>
									@endif
								</td>
								<td>{{ ucwords($payment->payee->user->firstname . ' ' . $payment->payee->user->lastname) }}</td>
								<td>{{ strtolower($payment->payee->user->email) }}</td>
								<td>{{ date('F d, Y h:i:s a', strtotime($payment->created_at)) }}</td>
								<td>{{ date('F d, Y h:i:s a', strtotime($payment->updated_at)) }}</td>
								<td><button class="btn btn-danger btn-xs">Remove</button></td>
							</tr>
							@include('admin.includes.modal-view-attachment')
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $verified_payments->count() + $verified_payments->perPage() * ($verified_payments->currentPage() - 1) }} of {{ $verified_payments->total() }}</strong></p>

			          <!-- Page Number render() -->
			          <div class="text-center"> {{ $verified_payments->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection