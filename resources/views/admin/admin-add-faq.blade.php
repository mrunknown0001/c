@extends('layouts.app')

@section('title') Add Frequently Asked Questions @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>Add Frequently Asked Questions</h1>
			<hr>
			<div class="row">
				<div class="col-md-8">
					@include('includes.all')
					
					<form action="{{ route('post_admin_add_faq') }}" method="POST">
						<div class="form-group">
							<input type="text" name="question" class="form-control" placeholder="Question" />
						</div>
						<div class="form-group">
							<textarea name="answer" class="form-control" placeholder="Answer" rows="10"></textarea>
						</div>
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<button class="btn btn-primary">Add FAQ</button>
							<a href="{{ route('admin_view_faq') }}" class="btn btn-danger">Cancel</a>
						</div>
					</form>
				</div>
			</div>

		</section>

	</div>


</div>