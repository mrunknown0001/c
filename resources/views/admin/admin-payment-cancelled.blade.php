@extends('layouts.app')

@section('title') Cancelled Payments @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Cancelled Payments</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Attachment</th>
								<th>Name</th>
								<th>Email Address</th>
								<th>Date of Payment</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($payments as $payment)
							<tr>
								<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#n-{{ $payment->id }}">View Attachent</button></td>
								<td>{{ ucwords($payment->payee->user->firstname . ' ' . $payment->payee->user->lastname) }}</td>
								<td>{{ strtolower($payment->payee->user->email) }}</td>
								<td>{{ date('F d, Y g:i:s A', strtotime($payment->created_at)) }}</td>
								<td><button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#r-{{ $payment->id }}">Review Again</button></td>
							</tr>
							@include('admin.includes.modal-review-again')
							@include('admin.includes.modal-view-attachment')
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $payments->count() + $payments->perPage() * ($payments->currentPage() - 1) }} of {{ $payments->total() }}</strong></p>

		          <!-- Page Number render() -->
		          <div class="text-center"> {{ $payments->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection