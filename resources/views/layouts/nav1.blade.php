    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top">
      <div class="container">
        <a class="navbar-brand" href="{{ route('get_landing_page') }}">CLLR Trading</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item">
              <a class="nav-link" href="{{ route('get_landing_page') }}">Home
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="javascript:void();" data-toggle="modal" data-target="#modal-login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:void();" data-toggle="modal" data-target="#modal-register">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:void();">FAQ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('get_about_page') }}">About</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

@include('modal-login')
@include('modal-register')

    