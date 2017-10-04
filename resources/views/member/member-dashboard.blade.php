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
					<h4>Today, {{ date('F d, Y') }} TBC Rate</h4>
					@include('includes.all')
				</div>
			</div>
		</section>

	</div>

</div>
@endsection