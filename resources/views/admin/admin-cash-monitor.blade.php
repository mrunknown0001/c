@extends('layouts.app')

@section('title') Cash Monitor @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Cash Monitor</h1>
			@include('includes.all')
			<div class="row">
				<div class="col-md-6">
					<h3>Total Cash In: &#8369; <span style="color: red;">{{ $cash->in_cash }}</span></h3>
				</div>
				<div class="col-md-6">
					<h3>Total Cash Out: &#8369; {{ $cash->out_cash }}</h3>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<table class="table table-hover">
						<thead>
							<th>Type</th>
							<th>Method</th>
							<th>Via</th>
							<th>From</th>
							<th>To</th>
							<th>Amount</th>
							<th>Remarks</th>
						</thead>
						<tbody>
							@foreach($monitors as $mon)
							<tr>
								<td>{{ strtoupper($mon->type) }}</td>
								<td>{{ strtoupper($mon->method) }}</td>
								<td>{{ strtoupper($mon->via) }}</td>
								<td>{{ strtoupper($mon->from) }}</td>
								<td>{{ strtoupper($mon->to) }}</td>
								<td>{{ $mon->amount }}</td>
								<td><i>{{ strtoupper($mon->remarks) }}</i></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</section>
		<p class="text-center"><strong>{{ $monitors->count() + $monitors->perPage() * ($monitors->currentPage() - 1) }} of {{ $monitors->total() }}</strong></p>

		<!-- Page Number render() -->
		<div class="text-center"> {{ $monitors->links() }}</div>

	</div>


</div>
@endsection