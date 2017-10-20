@extends('layouts.app')

@section('title') Members @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>{{ $members->count() }} Total Members</h3>
			<form action="" class="form-inline">
			    <div class="input-group">
			      <input type="text" name="keyword" class="form-control" placeholder="Search Name or ID Number">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="button">Go!</button>
			      </span>
			    </div>
			</form>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Member ID</th>
						<th>Name</th>
						<th>Active</th>
						<th>Balance</th>
						<th>Date Joined</th>
					</tr>
				</thead>
				<tbody>
					@foreach($members as $member)
					<tr>
						<td><a href="{{ route('admin_get_member_info', ['uid' => $member->uid]) }}">{{ $member->uid }}</a></td>
						<td><a href="{{ route('admin_get_member_info', ['uid' => $member->uid]) }}">{{ ucwords($member->firstname . ' ' . $member->lastname) }}</a></td>
						<td>
							@if($member->active == 1)
							Yes
							@else
							No
							@endif
						</td>
						<td>&#8369; {{ $member->member->balance->current }}</td>
						<td>{{ date('F d, Y', strtotime($member->created_at)) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<p class="text-center"><strong>{{ $members->count() + $members->perPage() * ($members->currentPage() - 1) }} of {{ $members->total() }}</strong></p>

	          <!-- Page Number render() -->
	         <div class="text-center"> {{ $members->links() }}</div>
		</section>
	</div>

</div>
@endsection