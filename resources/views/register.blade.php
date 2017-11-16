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

	<link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

  </head>

  <body>
  <div class="wrapper">
  	<div class="main-header text-center">
  		<h1><img src="{{ asset('uploads/images/logo.png') }}" alt=""></h1>
  	</div>
	<div id="register">
		<strong>Registration Form</strong>
		<hr>
        @include('includes.errors')
        @include('includes.error')
        @include('includes.success')
        @include('includes.notice')
  		<form action="{{ route('member_registration') }}" method="POST" autocomplete="off">
  			<div class="form-group">
  				<input type="text" name="firstname" class="form-control text-capitalize" placeholder="First Name" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="lastname" class="form-control text-capitalize" placeholder="Last Name" />
  			</div>
  			<div class="form-group">
  				<input type="email" name="email" class="form-control text-lowercase" placeholder="Email" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="mobile_number" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Mobile Number" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="address" class="form-control text-capitalize" placeholder="Address" />
  			</div>
  			<div class="form-group">
  				<input type="text" name="username" class="form-control text-lowercase" placeholder="Username" />
  			</div>
  			<div class="form-group">
  				<input type="password" name="password" class="form-control" placeholder="Password" />
  			</div>
  			<div class="form-group">
  				<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
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
  				<input type="text" name="sponsor_id" class="form-control" placeholder="Sponsor ID">
  			</div>
        <div class="form-group">
          <input type="text" name="upline_account_id" class="form-control" placeholder="Upline Account ID" />
        </div>

<!--         <div class="form-group">
          <div class="row">
            <div class="col-md-8">
              Do you want multiple accounts?
              <label>
                No <input type="radio" name="account" value="0" checked="">
              </label>
              
              <label>
                Yes <input type="radio" name="account" value="1" />
              </label>
              </div>
              <div class="col-md-4">
                <input type="number" name="number_of_accounts" class="form-control" placeholder="No. of Accounts" />
            </div>
          </div>
        </div> -->
        <div class="form-group">
          <p><i>By registering on this site, you agree to the <a href="#" data-toggle="modal" data-target="#modal-register">Terms and Conditons</a></i></p>
        </div>
  			<div class="form-group">

          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  				<button class="btn btn-primary">Register</button>
  				<a href="{{ route('get_landing_page') }}" class="btn btn-danger">Cancel</a>

  			</div>
  		</form>
      <p><a href="{{ route('get_member_login') }}">Have an account?</a></p>
  	</div>
  </div>
  <div id="">
	  @include('layouts.footer1')



<div class="modal fade" id="modal-register" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <div class="pull-left">Registration Terms and Conditions</div>
                <div class="pull-right"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
            </div>
            <div class="modal-body modal-body-register">
                <p>Condition Here</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet dicta earum minus quo nihil laudantium nam dolorem, accusamus quia libero odio voluptas quis, aliquid reiciendis magnam! Debitis, odit vitae.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem, laborum saepe non, debitis veniam aspernatur, a natus repellat esse minus aperiam dignissimos error ut ex incidunt veritatis, fugiat quos quas.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur ab quam minima fugit illo, odio dolor, id culpa soluta accusantium! Libero sed nesciunt id, magnam quod in praesentium, excepturi sunt.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere odit voluptates nemo saepe voluptate cumque cum rem enim repellendus adipisci, hic quod. In vero nostrum sed repellat, sequi labore eveniet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet architecto quas, est tenetur doloribus libero? Consequuntur, esse aut quos repudiandae dolore quia fuga hic quasi, nulla amet, optio dolor facilis.</p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" data-dismiss="modal">I Agree</button>
            </div>
        </div>

    </div>
</div>




  </div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  </body>

</html>
