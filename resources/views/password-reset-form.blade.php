<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CLLR Trading - Password Reset</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- <link href="{{  asset('css/full-slider.css') }}" rel="stylesheet"> -->

	<link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  </head>

  <body>
  <div class="wrapper">
  	<div class="main-header text-center">
  		<h1><img src="{{ asset('uploads/images/logo.png') }}" alt=""></h1>
  	</div>
	<div id="register">
		<strong>Password Reset Form</strong>
		<hr>
        @include('includes.errors')
        @include('includes.error')
        @include('includes.success')
        @include('includes.notice')
        <form action="{{ route('post_password_reset_token') }}" method="POST" autocomplete="off">
          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Enter New Password" />
          </div>
          <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Re Enter New Password" />
          </div>
          <div class="form-group">
            <input type="hidden" name="email" value="{{ $email }}" />
            <input type="hidden" name="token" value="{{ $token }}"  />
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <button class="btn btn-primary">Change Password</button>
          </div>
        </form>

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
