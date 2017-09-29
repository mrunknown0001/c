@extends('layouts.app')

@section('title') Member Downline @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>My Downlines</h3>
		</section>

		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h3>Level 1</h3>
				<h4>1. Downline</h4>
				<h4>2. Downline</h4>
				<h4>3. (Empty)</h4>
				<h4>4. (Empty)</h4>
				<h4>5. (Empty)</h4>
			</div>
		</div>
	</div>

</div>
@endsection