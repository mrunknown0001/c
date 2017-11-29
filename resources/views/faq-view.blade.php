@extends('layouts.app1')

@section('title') CLLR Trading - Frequently Asked Questions @endsection

@section('content')

    @include('layouts.nav1')
    <div style="height: 55px;"></div>
        <h3>Frequently Asked Questions</h3>
        <hr>
        <ul>
		<h3>{{  ucwords($faq->question) }}</h3>
		<p>{{ $faq->answer }}</p>
		</ul>
		<hr>
		<p><a href="{{ route('get_faq') }}">go to FAQ</a></p>
    </div>

@endsection