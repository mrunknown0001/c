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
							</tr>
						</thead>
						<tbody>
							@foreach($codes as $c)
							<tr>
								<td>{{ $c->code->code }}</td>
								<td>
									@if($c->usage > 4)
									Invalid/Used Code
									@else
									{{ $c->usage }}
									@endif
								</td>
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