<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CLLR Trading - Register</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- <link href="{{  asset('css/full-slider.css') }}" rel="stylesheet"> -->

	<!-- <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}"> -->

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  </head>

  <body>
  <div class="wrapper">
  	<div class="main-header text-center">
  		<h1>CLLR Trading</h1>
  	</div>
	<div id="register">
		<strong>Registration Form</strong>
		<hr>
        @include('includes.errors')
        @include('includes.error')
        @include('includes.success')
        @include('includes.notice')
  		<form action="#" method="POST" autocomplete="off">
  			<div class="form-group">
  				<input type="text" name="firstname" class="form-control" placeholder="First Name" required="" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="lastname" class="form-control" placeholder="Last Name" required="" />
  			</div>
  			<div class="form-group">
  				<input type="email" name="email" class="form-control" placeholder="Email" required="" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number" required="" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="address" class="form-control" placeholder="Address" required="" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="username" class="form-control" placeholder="Username" required="" />
  			</div>
  			<div class="form-group">
  				<input type="password" name="password" class="form-control" placeholder="Password" required="" />
  			</div>
  			<div class="form-group">
  				<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"  required="" />
  			</div>
  			<div class="form-group">
  				Do you have TBC account?
  				<label>
  					No <input type="radio" name="tbc" value="0" checked="">
  				</label>
  				
  				<label>
  					Yes <input type="radio" name="tbc" value="1" />
  				</label>
  				
  			</div>
  			<div class="form-group">
  				<input type="text" name="sponsor_id" class="form-control" placeholder="Sponsor ID (Optional)">
  			</div>
  			<div class="form-group">
  				<button class="btn btn-primary">Register</button>
  				<a href="{{ route('get_landing_page') }}" class="btn btn-danger">Cancel</a>
  			</div>
  		</form>
  	</div>
  </div>
  <div id="">
	  @include('layouts.footer1')
  </div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  </body>

</html>
