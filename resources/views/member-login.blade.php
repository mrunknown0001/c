<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CLLR Trading - Member Login</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- <link href="{{  asset('css/full-slider.css') }}" rel="stylesheet"> -->

	<!-- <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}"> -->

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  </head>

  <body>
  <div class="wrapper">
  	<div class="main-header text-center">
      <h1><img src="{{ asset('uploads/images/logo.png') }}" alt=""></h1>
  	</div>
	<div id="register">
		<strong>Member Login</strong>
		<hr>
      @include('includes.errors')
      @include('includes.error')
      @include('includes.success')
      @include('includes.notice')
  		<form action="{{ route('post_login') }}" method="POST" autocomplete="off">
  			<div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="Username" />   
        </div>
  			<div class="form-group">
  				<input type="password" name="password" class="form-control" placeholder="Password" />
  			</div>

  			<div class="form-group">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  				<button class="btn btn-primary">Login</button>
  				<a href="{{ route('get_landing_page') }}" class="btn btn-danger">Cancel</a>
  			</div>
  		</form>
      <p><a href="#">Forgot Password?</a></p>
      <p><a href="{{ route('member_registration') }}">Don't have and account?</a></p>
  	</div>
  </div>
  <div id="footer">
	  @include('layouts.footer1')
  </div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  </body>

</html>
