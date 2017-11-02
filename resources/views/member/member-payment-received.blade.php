@extends('layouts.app')

@section('title') Member Payment Received @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Received Payments</h3>
			<div class="row">
				<div class="col-md-10">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Attachment</th>
							<th>Date Sent</th>
							<th>Date Received</th>
							<th>Send Via</th>
						</tr>
					</thead>
					<tbody>
						@foreach($payments as $p)
						<tr>
							<td><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#n-{{ $p->id }}">View Attachment</button></td>
							<td>{{ date('F d, Y h:i A', strtotime($p->created_at)) }}</td>
							<td>{{ date('F d, Y h:i A', strtotime($p->updated_at)) }}</td>
							<td>{{ strtoupper($p->sent_thru) }}</td>
							@include('member.includes.modal-view-attachment')
						</tr>
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