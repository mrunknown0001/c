@extends('layouts.app')

@section('title') Member Profile Picture Change @endsection

@section('content')
<div class="wrapper">
	@include('member.member-menu')
	<div class="content-wrapper">
		<section class="content-header">
			<h3>Change Profile Picture</h3>
			<hr>
			<div class="row">
				<div class="col-md-10">
					@include('includes.all')
		          <form action="{{ route('post_member_profile_picture_change') }}" method="POST" enctype="multipart/form-data">
		            <div class="form-group">
		                <input type="file" name="image" size="40" accept="image/x-png,image/gif,image/jpeg">
		            </div>
		            <div class="form-group">
		              <input type="hidden" name="_token" value="{{ csrf_token() }}" />
		              <button class="btn btn-primary">Upload &amp; Update Profile Picture</button>
		            </div>
		          </form>
				</div>
			</div>
		</section>

	</div>

</div>
@endsection