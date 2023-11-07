@extends('teckiproadmin::site.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::site.layouts.pricing-nav')
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

</style>
@endpush
@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->

        <form action="{{ route('plans.reviewsubscription') }}" method="post">
            @csrf

        <section class="py-8" id="pricing"
        x-data="{
            plan: @js($details),
            payment_method: '',
            default_gateway: @js($defaultPaymentGateway),
            paddle_pay_link: '',
            pricingtype: @js($pricingtype),

            init: function(){
                if(this.default_gateway=='stripe'){
                     $('#stripe').attr('checked', true)
                }else {
                    $('#paddle').attr('checked', true);
                    let name = this.plan.name.replace('\ \g','_');
                    let paddleid = '';
                    if(this.pricingtype=='per_month')
                    {
                        paddleid = this.plan.paddle_id.monthly;
                    }else if(this.pricingtype=='per_year'){
                        paddleid = this.plan.paddle_id.yearly;
                    }else if(this.pricingtype=='per_year'){
                        paddleid = this.plan.paddle_id.one_time_purchase;
                    }else{
                        return false;
                    }

                    let url = 'site/pricing/plan/paddle/paylink/'+name+'/'+paddleid;
                    //this.paddle_pay_link = axios(url);
                }
            }
        }">

            <div class="container">

              <div class="row">
                @include('teckiproadmin::flash-message')
              </div>

              <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xxl-5 text-center mb-3">
                  <h6 class="fw-bold fs-4 display-3 lh-sm mb-3">Review Order</h6>
                </div>
              </div>
              <div class="row ">

                <div class="col-md-8">
                    <div class="card mb-4 border-0">
                        <div class="card-header border-1">

                            <div class="row">
                                <div class="col-md-7"><h5 class="fw-bold text-left" x-text="plan.name"></h5></div>
                                <div class="col-md-5 text-right"><h6 class=""> {{ $priceFormatted }}</h6></div>
                            </div>
                        </div>



                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-unstyled mb-4">
                                        <template x-for="feature in plan.features">
                                            <li class="text-700 py-2 text-secondary"><b x-text="feature.value"></b>  <span x-text="feature.code"></span></li>
                                        </template>

                                    </ul>

                                    <fieldset>
                                        <legend>Payment Method</legend>

                                        <div class="form__radios">
                                          <div class="form__radio">
                                            <label for="paddle">
                                               <img class="vendorimg"  src="{{ asset('vendor/package-dep/checkout/paddle.png') }}">
                                                Paddle</label>
                                            <input checked id="paddle" x-mdoel="payment_method" value="paddle" name="payment-method" type="radio" />
                                          </div>

                                          <div class="form__radio">
                                            <label for="stripe">
                                                <img class="vendorimg" src="{{ asset('vendor/package-dep/checkout/stripe-icon.svg') }}">
                                                Stripe</label>
                                            <input id="stripe"  name="payment-method" x-mdoel="payment_method" value="stripe" type="radio" />
                                          </div>


                                        </div>
                                      </fieldset>

                                </div>
                            </div>



                            <br><br>

                             <div x-if="default_gateway=='paddle'" x-ignore>
                               <h4>Paddle</h4>
                               <div ><x-teckiproadmin::plans.paddle></x-teckiproadmin::plans.paddle></div>

                             </div>

                             <template x-if="default_gateway=='stripe'" x-ignore>
                                <h4>Stripe</h4>
                             </template>



                        </div>
                    </div>
                </div>







                <div class="col-md-4">

                    <div class="card shadow-md mb-4 border-1">
                        <div class="card-header border-bottom-0 pt-5 pb-5">
                          <h5 class="fw-bold text-center">Order Summary</h5>
                          <span class="text-700 text-center d-block" x-text="plan.description"></span>

                        </div>

                        <div class="card-body mx-auto">



                        </div>
                    </div>
                </div>




              </div>
            </div>
            <!-- end of .container-->

          </section>
        </form>
          <!-- <section> close ============================-->
          <!-- ============================================-->
 @endsection


 @push('after-scripts')
 <script>

Paddle.Checkout.open({
override: 'https://checkout.paddle.com/checkout/custom/783101'
});

 </script>
 @endpush
