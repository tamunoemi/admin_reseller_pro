<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ appName() }} | @yield('title')</title>

    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="@yield('meta_author', 'Robert Tamunoemi')">
    @yield('meta')

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/plans/assets/img/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/plans/assets/img/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/plans/assets/img/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('vendor/plans/assets/img/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('vendor/plans/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('vendor/plans/assets/img/favicons/mstile-150x150.png') }} ">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('vendor/plans/assets/css/theme.css') }}" rel="stylesheet" />
    <livewire:styles />
    @stack('after-styles')
    <script defer src="{{ asset('vendor/package-dep/js/alpine.js') }}"></script>
    <style>
        .text-right{
            text-align: right;
        }
        .box-1{
            box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;
            cursor: pointer;
        }
        .box-1:hover{
            box-shadow: rgba(240, 46, 170, 0.4) 5px 5px, rgba(240, 46, 170, 0.3) 10px 10px, rgba(240, 46, 170, 0.2) 15px 15px, rgba(240, 46, 170, 0.1) 20px 20px, rgba(240, 46, 170, 0.05) 25px 25px;
        }
        .box-1 h4:nth-child(1){
          text-align: center;
          font-size: 0.8rem;
          padding: 10px;
          word-wrap: break-word;
        }
        .vendorimg{
            width: 20px;
        }


    </style>

    @stack('header-scripts')
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">

        @yield('nav')

        @yield('content')


        @yield('footer')
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script href="{{ asset('vendor/plans/vendors/@popperjs/popper.min.js') }} "></script>
    <script href="{{ asset('vendor/plans/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script href="{{ asset('vendor/plans/vendors/is/is.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('vendor/plans/assets/js/theme.js') }} "></script>

    <script src="{{ asset('vendor/package-dep/js/jquery.js') }}"></script>
    <script src="{{ asset('vendor/package-dep/js/axios.js') }}"></script>
    <livewire:scripts />

    @stack('after-scripts')

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400&amp;display=swap" rel="stylesheet">
  </body>

</html>
