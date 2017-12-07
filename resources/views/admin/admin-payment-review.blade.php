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
								<th>Contact Number</th>
								<th>Date of Payment</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pending_payments as $payment)
							<tr>
								<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#n-{{ $payment->id }}">View Attachent</button></td>
								<td>
									@if($payment->status == 0)
										Unverified
									@else
										Verified
									@endif
								</td>
								<td>{{ ucwords($payment->payee->user->firstname . ' ' . $payment->payee->user->lastname) }}</td>
								<td>{{ strtolower($payment->payee->user->email) }}</td>
								<td>{{ $payment->payee->user->mobile }}</td>
								<td>{{ date('F d, Y g:i:s A', strtotime($payment->created_at)) }}</td>
								<td><button class="btn btn-success btn-xs" data-toggle="modal" data-target="#v-{{ $payment->id }}">Verify</button> | <button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#c-{{ $payment->id }}">Cancel</button></td>
							</tr>
							@include('admin.includes.modal-cancel-payment')
							@include('admin.includes.modal-view-attachment')
							@include('admin.includes.modal-confirm-verify-payment')
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