@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection

@push('after-styles')
<style>

:root {
  --color-background: #fae3ea;
  --font-family-base: Poppin, sans-serif;
  --font-size-h1: 1.25rem;
  --font-size-h2: 1rem;
}

    button {
  border: 0;
  color: inherit;
  cursor: pointer;
  font: inherit;
}

fieldset {
  border: 0;
  margin: 0;
  padding: 0;
  color: black;
}

h1 {
  font-size: var(--font-size-h1);
  line-height: 1.2;
  margin-block: 0 1.5em;
}

h2 {
  font-size: var(--font-size-h2);
  line-height: 1.2;
  margin-block: 0 0.5em;
}

legend {
  font-weight: 600;
  margin-block-end: 0.5em;
  padding: 0;
}

input {
  border: 0;
  color: inherit;
  font: inherit;
}

input[type="radio"] {
  accent-color: var(--color-primary);
}

table {
  border-collapse: collapse;
  inline-size: 100%;
}

tbody {
  color: #b4b4b4;
}

td {
  padding-block: 0.125em;
}

tfoot {
  border-top: 1px solid #b4b4b4;
  font-weight: 600;
}

.align {
  display: grid;
  place-items: center;
}

.button {
  align-items: center;
  background-color: var(--color-primary);
  border-radius: 999em;
  color: #fff;
  display: flex;
  gap: 0.5em;
  justify-content: center;
  padding-block: 0.75em;
  padding-inline: 1em;
  transition: 0.3s;
}

.button:focus,
.button:hover {
  background-color: #e96363;
}

.button--full {
  inline-size: 100%;
}

.card {
  border-radius: 1em;
  background-color: var(--color-primary);
  color: #fff;
  padding: 1em;
}

.form {
  display: grid;
  gap: 2em;
}

.form__radios {
  display: grid;
  gap: 1em;
}

.form__radio {
  align-items: center;
  background-color: #fefdfe;
  border-radius: 1em;
  box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
  display: flex;
  padding: 1em;
}

.form__radio label {
  align-items: center;
  display: flex;
  flex: 1;
  gap: 1em;
}

.header {
  display: flex;
  justify-content: center;
  padding-block: 0.5em;
  padding-inline: 1em;
}

.icon {
  block-size: 1em;
  display: inline-block;
  fill: currentColor;
  inline-size: 1em;
  vertical-align: middle;
}

.iphone {
  background-color: #fbf6f7;
  background-image: linear-gradient(to bottom, #fbf6f7, #fff);
  border-radius: 2em;
  block-size: 812px;
  box-shadow: 0 0 1em rgba(0, 0, 0, 0.0625);
  inline-size: 375px;
  overflow: auto;
  padding: 2em;
}
.ftl{ font-size: 0.9rem}
.per{
  font-size: small;
  display: flow;
  color: cadetblue;
}
</style>
@endpush
@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->


        <section class="py-8" id="pricing"
        x-data="{
            plan: @js($details)
        }">

            <div class="container">

              <div class="row">
                @include('teckiproadmin::flash-message')
              </div>

           
              <div class="row ">

                <div class="col-md-8">
                    <div class="card mb-4 border-0">

                        <div class="card-body">
 
        
                            @auth
                              <x-paddle-checkout :override="$paddlePayLink" class="w-full" height="500" />
                            @endauth

                            @guest
                            <p>You will need to create an account with us to proceed with this checkout</p>
                            <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
                            @endguest


                        </div>
                    </div>
                </div>







                <div class="col-md-4">

                    <div class="card shadow-md mb-4 border-1">
                        <div class="card-header border-bottom-0 pt-5">
                          <span class="text-700 text-center d-block"  >Subscribe to {{ $details['name'] }}</span>
                          <h5 class="fw-bold text-center">${{ $realPrice }} <span class="per">{{ $priceTypeFormatted }}</span></h5>

                          <hr>
                       
                        </div>

                        <div class="card-body mx-auto">


                          <h6>Features</h6>
                          <div class="row">
                            <div class="col-md-12">
                                <ul class="list-unstyled mb-4">
                                    <template x-for="feature in plan.features">
                                        <li class="text-700 py-2 text-secondary ftl"><b x-text="feature.value"></b>  <span x-text="feature.code"></span></li>
                                    </template>

                                </ul>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>




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
