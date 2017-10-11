@extends('layouts.app')

@section('title') Member Balance @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Member Balance</h3>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
					<h1>My Balance: {{ $balance->current }}</h1>
				</div>
			</div>
		</section>

	</div>

</div>
@endsection