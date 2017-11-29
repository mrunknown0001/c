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
				<div class="col-md-10">
					@include('includes.all')
					<p><a href="{{ route('admin_add_faq') }}">Add Frequently Asked Question</a></p>
					<hr>
					<ul>
					@foreach($faqs as $faq)
					<li><a href="{{ route('admin_view_faq_item', ['id' => $faq->id, 'question' => strtolower(str_replace(' ', '-', $faq->question))]) }}">{{ ucwords($faq->question) }}</a></li>
					@endforeach
					</ul>
					<div>{{ $faqs->links() }}</div>
				</div>
			</div>

		</section>

	</div>


</div>
@endsection