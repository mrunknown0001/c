@extends('layouts.app')

@section('title') Member Dashboard @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Dashboard</h3>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					@if(count($balance) > 0)
					<h4>Your Balance: $balance->current</h4>
					@endif
				</div>
			</div>
		</section>

	</div>

</div>
@endsection