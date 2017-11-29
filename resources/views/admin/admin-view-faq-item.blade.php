@extends('layouts.app')

@section('title') Frequently Asked Question @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1> Frequently Asked Question</h1>
			<hr>
			<div class="row">
				<div class="col-md-8">
					@include('includes.all')
					
					<h3>{{ $faq->question }}</h3>
					<hr>
					<p>{{ $faq->answer }}</p>
					<hr>
				</div>
			</div>

		</section>

	</div>


</div>