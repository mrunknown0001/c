@extends('layouts.app')

@section('title') Member Payout @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Member Cash Payout</h1>
			<hr>
<!-- 			<form action="{{ route('admin_payout_date_filter') }}" method="post">
				<div class="input-group">
					<input type="date" name="from" />
					to
					<input type="date" name="to" />
					&nbsp;
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<button  type="button" class="btn btn-primary btn-xs"><i class="fa fa-filter"></i> Filter</button>
					&nbsp;
				</div>
			</form> -->
			<button class="pull-left btn btn-primary" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
			<hr>
			<div class="row">
				<div class="col-md-8">
					@include('includes.all')
					<table class="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Total Cash</th>
								<th>Thru</th>
							</tr>
						</thead>
						<tbody>
							@foreach($members as $member)
							<tr>
								<td><a href="{{ route('admin_get_member_info', ['uid' => $member->member->uid]) }}">{{ ucwords($member->member->firstname . ' ' . $member->member->lastname) . ' - ' . $member->member->uid }}</a></td>
								{{-- total cash of member total plus direct referral --}}
								<td>&#8369; {{ $member->total + $member->direct_referral }}</td>
								<td>{{ $member->member->default_payout->mop }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $members->count() + $members->perPage() * ($members->currentPage() - 1) }} of {{ $members->total() }}</strong></p>

			        <!-- Page Number render() -->
			        <div class="text-center"> {{ $members->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection