@extends('layouts.app')

@section('title') Frequently Asked Questions @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Frequently Asked Questions</h1>
			<hr>
			<div class="row">
				<div class="col-md-6">
					@include('includes.all')

				</div>
			</div>

		</section>

	</div>


</div>
@endsection