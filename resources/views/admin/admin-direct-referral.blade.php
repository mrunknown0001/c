@extends('layouts.app')

@section('title') Direct Referral @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Direct Referral</h1>
			<hr>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Sponsor</th>
								<th>Member</th>
								<th>Paid</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($referrals as $ref)
							<tr>
								<td>{{ $ref->sponsor }}</td>
								<td>{{ $ref->member }}</td>
								<td>
									@if($ref->paid == 1)
									<button class="btn btn-success btn-xs">Yes</button>
									@else
									<button class="btn btn-warning btn-xs">No</button>
									@endif
								</td>
								<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#direct-{{ $ref->id }}">Pay</button></td>
							</tr>
							@include('admin.includes.modal-pay-direct-referral')
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $referrals->count() + $referrals->perPage() * ($referrals->currentPage() - 1) }} of {{ $referrals->total() }}</strong></p>

		          <!-- Page Number render() -->
		          <div class="text-center"> {{ $referrals->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection