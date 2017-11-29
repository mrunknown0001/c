@extends('layouts.app1')

@section('title') CLLR Trading - Frequently Asked Questions @endsection

@section('content')

    @include('layouts.nav1')
    <div style="height: 55px;"></div>
        <h3>FAQ</h3>
        <ul>
		@foreach($faqs as $faq)
		<li><a href="{{ route('view_faq_item', ['id' => $faq->id, 'question' => strtolower(str_replace(' ', '-', $faq->question))]) }}">{{ ucwords($faq->question) }}</a></li>
		@endforeach
		</ul>
		<div>{{ $faqs->links() }}</div>
    </div>

@endsection