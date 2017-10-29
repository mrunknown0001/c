@extends('layouts.app')

@section('title') Member Payment Send @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Send Payment Attachment</h3>
		</section>
		<hr>
		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				@include('includes.all')
				<form action="{{ route('post_member_payment_send') }}" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<select name="sent_thru" id="" class="form-control">
							<option value="">Select Payment Options</option>
							@foreach($options as $option)
							<option value="{{ $option->name }}">{{ strtoupper($option->name) }} - {{ $option->description }}</option>
							@endforeach
							<!-- <option value="Coins.ph" selected="">Coins.ph (Prefered)</option>
							<option value="Palawan Express">Palawan Express</option>
							<option value="Cebuana">Cebuana</option> -->
						</select>
					</div>
					<div class="form-group">
						<textarea name="description" id="" cols="30" rows="8" class="form-control" placeholder="Optional..."></textarea>
					</div>
					<div class="form-group">
						<input type="file" name="payment_image" accept="image/x-png,image/gif,image/jpeg" />
					</div>
					<div class="form-group">
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<button class="btn btn-primary">Upload And Send Payment</button>
					</div>
				</form>
			</div>
		</div>
	</div>

</div>
@endsection