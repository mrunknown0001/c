@extends('layouts.app')

@section('title') User Logs @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>User Logs</h1>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>User</th>
								<th>Action</th>
								<th>Time &amp; Date</th>

							</tr>
						</thead>
						<tbody>
							@foreach($logs as $log)
							<tr>
								<td>{{ $log->user }}</td>
								<td>{{ strtoupper($log->action) }}</td>
								<td>{{ date('H:i:s a - l - F j, Y ', strtotime($log->created_at)) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div>{{ $logs->links() }}</div>
				</div>
			</div>
		</section>
	</div>

</div>
@endsection