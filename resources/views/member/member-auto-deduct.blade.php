@extends('layouts.app')

@section('title') Auto-Deduct @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Auto-Deduct</h3>
			<div class="row">
				<div class="col-md-6">
					<h4>Status: 
						@if($ad->status == 1)
						<button class="btn btn-success btn-lg">Auto-Deduct is turned ON</button>
						@else
						<button class="btn btn-danger btn-lg">Auto-Deduct is turned OFF</button>
						@endif
					</h4>
					<hr>
					<hr>
					@include('includes.all')
						@if($ad->status == 1)
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-warning">
									<div class="panel-heading">Available Auto-Deduct Fund</div>
									<div class="panel-body">
										<h1 class="text-center">&#8369; {{ Auth::user()->autodeduct->cash }}</h1>
									</div>
								</div>	
							</div>
						</div>
						<!-- <form action="{{ route('turn_off_auto_deduct') }}" method="POST">
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Ente Password To Confirm" required="" />
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<button class="btn btn-danger">Turn Off</button>
							</div>
						</form> -->
						@else
						<form action="{{ route('turn_on_auto_deduct') }}" method="POST">
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Ente Password To Confirm" required="" />
							</div>
							<div class="form-group">
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<button class="btn btn-success">Turn On</button>
							</div>
						</form>
						<hr>
						<i>Note: You cannot Turn Off Auto-Deduct Feature once you Turn it On.</i>
						@endif


				</div>
			</div>
		</section>

	</div>

</div>
@endsection