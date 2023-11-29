<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container"><a class="navbar-brand d-flex align-items-center fw-bold fs-2" href="index.html">
        <div class="text-warning">App</div>
        <div class="text-1000">Lab</div>
      </a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto pt-2 pt-lg-0">
          <li class="nav-item" data-anchor="data-anchor"><a class="nav-link fw-medium active" aria-current="page" href="#home">Home</a></li>
          <li class="nav-item" data-anchor="data-anchor"><a class="nav-link fw-medium" href="#features">Key Features</a></li>
          <li class="nav-item" data-anchor="data-anchor"><a class="nav-link fw-medium" href="#pricing">Pricing</a></li>
          <li class="nav-item" data-anchor="data-anchor"><a class="nav-link fw-medium" href="#testimonial">Testimonial</a></li>
          <li class="nav-item" data-anchor="data-anchor"><a class="nav-link fw-medium" href="#faq">FAQ</a></li>


          @auth
            <li class="nav-item" ><a class="fw-medium btn btn-md btn-success rounded-pill order-0" href="{{ route(env('FRONTENDROUTENAME').'.user.dashboard') }}">Dashboard</a></li>
          @else
            <li class="nav-item" ><a class="nav-link fw-medium" href="{{ route(env('FRONTENDROUTENAME').'.auth.login') }}">Login</a></li>
          @endauth
        </ul>


        @unless (Auth::check())
            @if (config('boilerplate.access.user.registration'))
                <form class="ps-lg-5">
                    <a href="{{ route(env('FRONTENDROUTENAME').'.auth.register') }}" class="btn btn-lg btn-primary rounded-pill order-0">@lang('Register')</a>
                </form>
            @endif
        @endunless

      </div>
    </div>
  </nav>
