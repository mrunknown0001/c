@extends('layouts.app')

@section('title') Member Cash @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>My Cash</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Available Cash</div>
						<div class="panel-body">
							<h1 class="text-center">&#8369; {{ $cash->total }}</h1>
						</div>
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-warning">
						<div class="panel-heading">Available TBC Deposit</div>
						<div class="panel-body">
							<h1 class="text-center">&#8369; {{ $tbc_deposit->tbc_deposit }}</h1>
						</div>
					</div>	
				</div>
			</div>
		</section>
	</div>

</div>
@endsection