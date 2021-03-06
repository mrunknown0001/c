<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="keyword" content="CLLR Trading">

		<title>@yield('title')</title>

		{{-- Bootstrap 3.3.7 --}}
		{{-- Builtin in Laravel 5.3 --}}
		<link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

		<link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">

		{{-- FontAwesome 4.7.0.3--}}
		<link rel="stylesheet" href="{{ URL::asset('fontawesome/css/font-awesome.min.css') }}">

		{{-- Ionicons 2 --}}
		<!-- <link rel="stylesheet" href="{{ URL::asset('css/ionicons.css') }}"> -->


		<!-- <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-toggle.min.css') }}"> -->

		{{-- Admin LTE --}}
		<link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">

		{{-- Admin LTE Skin --}}
		<link rel="stylesheet" href="{{ URL::asset('dist/css/skins/skin-yellow.min.css') }}">

		<link rel="icon" href="{{ asset('uploads/images/logo.ico') }}">

		<link rel="stylesheet" type="text/css" href="{{ asset('css/printjs.min.css') }}">
		<!-- <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css"> -->


		<style type="text/css">
			@media print {
		    	@page { margin: 0; }
				body { margin: 1.6cm; }
				#print{ visibility: visible; }
				#printbutton, #headtitle {
					display: none;
				}
				#info {
					display: : inherit;
				}
				footer {
					display: none;
				}
		    }
		    @media screen {
		    	#info, #footnote {
		    		display: none;
		    	}
		    }
		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->


	</head>
	<body class="hold-transition skin-yellow sidebar-mini">
		@yield('content')

		{{-- jQuery2.2.3 --}}
		<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

		{{-- Bootstrap JS --}}
		<script src="{{ asset('js/app.js') }}"></script>

		{{-- AdminLTE JS --}}
		<script src="{{ asset('dist/js/app.min.js') }}"></script>

		<!-- <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script> -->

		<script src="{{ asset('js/printjs.min.js') }}"></script>
		<!-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script> -->
	</body>
</html>