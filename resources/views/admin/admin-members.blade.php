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
			      <input type="text" name="keyword" class="form-control" placeholder="Search">
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
						<th>Date Joined</th>
					</tr>
				</thead>
				<tbody>
					@foreach($members as $member)
					<tr>
						<td>{{ $member->uid }}</td>
						<td>{{ ucwords($member->firstname . ' ' . $member->lastname) }}</td>
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