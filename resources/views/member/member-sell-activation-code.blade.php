@extends('layouts.app')

@section('title') Member Sell Activation Code @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>My Sell Activation Code</h3>

			<div class="row">
				<div class="col-md-10">
					<strong>Available Sell Codes</strong>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Code</th>
								<th>Used</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($codes as $c)
							<tr>
								<td>{{ $c->code->code }}</td>
								<td>
									@if($c->usage > 0)
									Invalid/Used Code
									@else
									Not Used
									@endif
								</td>
								<th>
									@if($c->usage == 0)
									<button class="btn btn-primary btn-xs">Sell</button>
									@else
									Not Able to Sell
									@endif
								</th>
							</tr>
							@endforeach
						</tbody>
					</table>
					<p class="text-center"><strong>{{ $codes->count() + $codes->perPage() * ($codes->currentPage() - 1) }} of {{ $codes->total() }}</strong></p>

			          <!-- Page Number render() -->
			          <div class="text-center"> {{ $codes->links() }}</div>
				</div>
			</div>
		</section>
	</div>

</div>
@endsection