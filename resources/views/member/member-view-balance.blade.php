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
					<h1 style="color: red;">My Balance: &#8369; {{ $balance->current }}</h1>
					<p>If you already sent/deposited payment. Click <a href="{{ route('member_payment_send') }}">here</a></p>
				</div>
			</div>
		</section>

	</div>

</div>
@endsection