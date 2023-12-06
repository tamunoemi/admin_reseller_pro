@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection

@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->




        <section class="py-8" id="pricing" >

            <div class="container">

              <div class="row">
                @include('teckiproadmin::flash-message')
              </div>

              <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xxl-5 text-center mb-3">
                  <h6 class="fw-bold fs-4 display-3 lh-sm mb-3">Get awesome features, without extra charges</h6>
                  <p class="mb-4">The rise of mobile devices transforms the way we consume information entirely and the world's most elevant channels such as Facebook.</p>
                </div>
              </div>
              <div class="row flex-center">

               {!! $embed !!}

              </div>
            </div>
            <!-- end of .container-->

          </section>
        
          <!-- <section> close ============================-->
          <!-- ============================================-->
 @endsection

 @push('after-scripts')
 <script>



 </script>
 @endpush
