<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', env('PRODUCT_CREATOR'))">
    @yield('meta')

    @stack('before-styles')
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    {{-- Boostrap icon: https://icons.getbootstrap.com/?q=uploa --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <style>
        .bi {
            flex: 0 0 56px;
            font-size: 1.09375rem;
            text-align: center;
            transition: 0.3s;
            fill: currentColor;
            margin-left: -1rem;
        }
    </style>
    <livewire:styles />
    @stack('after-styles')
  

</head>

<body class="c-app">

    @include('teckiproadmin::includes.sidebar')

    <div class="c-wrapper c-fixed-components">

        @if ( Session::has('flashSuccess') )
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Notice!</strong> {{ Session::get('flash_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
        </div>

        @endif


        @include('teckiproadmin::includes.header')


        {{-- @include('teckiproadmin::includes.partials.read-only') --}}
        @include('teckiproadmin::includes.partials.logged-in-as')
        @include('teckiproadmin::includes.partials.announcements')

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">

                        @yield('content')
                    </div>
                    <!--fade-in-->
                </div>
                <!--container-fluid-->
            </main>
        </div>
        <!--c-body-->

        @include('teckiproadmin::includes.footer')
    </div>
    <!--c-wrapper-->

    @stack('before-scripts')

    <livewire:scripts />

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
 


  

    @stack('after-scripts')
</body>

</html>
