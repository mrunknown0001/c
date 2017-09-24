@extends('layouts.app')

@section('title') Admin Dashboard @endsection

@section('content')
<div class="wrapper">
	@include('admin.admin-menu')
	<div class="content-wrapper">
		<section class="content-header">
			Dashboard
		</section>
	</div>

</div>
@endsection