{{-- https://codepen.io/pepperface/pen/GppQvX --}}
@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection

@push('before-styles')
<style>
$primBlue: #0073ff;
$white: #fff;
$blueGray: #607d8b;
$slate: #54617a;

@import url(https://fonts.googleapis.com/css?family=Roboto);
@font-face {
    font-family: 'bariolregular';
    src: url('https://res.cloudinary.com/dw1zug8d6/raw/upload/v1541747126/fonts/bariol/bariol_regular-webfont.eot'),
         url('https://res.cloudinary.com/dw1zug8d6/raw/upload/v1541747224/fonts/bariol/bariol_regular-webfont.woff2') format('woff2'),
         url('https://res.cloudinary.com/dw1zug8d6/raw/upload/v1541747128/fonts/bariol/bariol_regular-webfont.woff') format('woff'),
         url('https://res.cloudinary.com/dw1zug8d6/raw/upload/v1541747127/fonts/bariol/bariol_regular-webfont.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

$bariol: 'bariolregular';
$roboto: 'Roboto', sans-serif;

.payment-success{
  width: 410px;
  box-shadow: 0 13px 45px 0 rgba(51, 59, 69, 0.1);
  margin: auto;
  border-radius: 10px;
  text-align: center;
  position: relative;
  font-family: $roboto;
  .header{
    position: relative;
    height: 7px;
  }
  .body{
    padding: 0 50px;
    padding-bottom: 25px;
  }
  
  .close{
    position: absolute;
    color: $primBlue;
    font-size: 20px;
    right: 15px;
    top: 11px;
    cursor: pointer;
  }
  .title{
    font-family: $bariol;
    font-size: 32px;
    color: $slate;
    font-weight: normal;
    margin-bottom: 10px;
  }
  .main-img{
    width: 243px;
  }
  p{
    font-size: 13px;
    color: $blueGray;
  }
  .btn{
    border: none;
    border-radius: 100px;
    width: 100%;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0;
    outline: none;
    cursor: pointer;
    position: relative;
    &.btn-primary{
      background: $primBlue;
      color: $white;
    }
  }
  .cancel{
    text-decoration: none;
    font-size: 14px;
    color: $blueGray;
  }
}

</style>
@endpush


@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->

        <section class="py-8" id="faq">

            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-5 col-lg-6 text-center mb-3">
                  <h6 class="fw-bold fs-4 display-3 lh-sm mb-3">Payment successfull</h6>
                  <p class="mb-5">Your payment was successful! You can
                    now continue using {{ env('APP_NAME') }}.</p>

                    <a href="{{ url('login') }}" class="btn btn-primary">Go to dashboard</a>
                </div>

               
              </div>
            </div>
            <!-- end of .container-->
        
        </section>

 @endsection
