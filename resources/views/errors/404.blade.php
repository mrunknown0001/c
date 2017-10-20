<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Page Not Found - CLLR Trading</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{  asset('css/full-slider.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <link rel="icon" href="{{ asset('uploads/images/logo.ico') }}">

    <style type="text/css">
        body {
            background: url("{{ url('uploads/images/errors/404.JPG') }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            background-size: cover;
            -o-background-size: cover;
        }
    </style>

  </head>

  <body>
  <div class="wrapper">
    <br>
    <h4 class="text-center"><a href="{{ route('get_landing_page') }}" style="color: orange;"> Home</a></h4>
  </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

  </body>

</html>
