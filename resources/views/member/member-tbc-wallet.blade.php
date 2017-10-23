@extends('layouts.app')

@section('title') Member TBC Wallet @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<!-- <h3>My TBC Wallet</h3> -->
			<div class="row">
				<div class="col-md-10 col-md-offset-2">
					<!-- <h4><i>TBC Wallet is temporarily inactive. Developers are working on it to back it online.</i></h4>
 -->
					<img src="{{ URL::asset('uploads/images/errors/tbc_unavailable.jpg') }}" class="img-responsive" alt="">
				</div>
			</div>
		</section>
	</div>

</div>
@endsection