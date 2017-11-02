@extends('layouts.app')

@section('title') Pending Downlines @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Pending Downlines</h3>
			<div class="row">
				<div class="col-md-10 ">
					<table class="table">
						<thead>
							<tr>
								<th>Account Number</th>
								<th>Owner</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($downlines as $downline)
							<tr>
								<td>{{ $downline->account_id }}</td>
								<td>{{ ucwords($downline->member->member->firstname . ' ' . $downline->member->member->lastname) }}</td>
								<td>Assign Downline</td>
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