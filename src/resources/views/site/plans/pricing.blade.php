@extends('teckiproadmin::site.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::site.layouts.pricing-nav')
@endsection

@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->

        <form id="form" action="{{ route('plans.reviewsubscription') }}" method="post">
            @csrf

            <input type="hidden" name="plan_id" id="plan_id" value="">
            <input type="hidden" name="selected_plan_type" id="selected_plan_type" value="monthly_yearly">

        <section class="py-8" id="pricing" x-data="{
            plan_option: true,
            sortPlan(e){
                alert(this.plan_option)
            },
            plans: @js($plans),
        }">

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
                <div class="col-12 mb-3">
                  <div class="d-flex justify-content-center">
                    <label class="form-check-label me-2" for="customSwitch1">Monthly</label>
                    <div class="form-check form-switch">
                      <input class="form-check-input" id="customSwitch1" name="pricingtype" x-on:change="sortPlan" x-model="plan_option" type="checkbox" checked="checked" />
                      <label class="form-check-label align-top" for="customSwitch1">Yearly</label>
                    </div>
                  </div>
                </div>



  <template x-for="plan in plans" :key="plan.id">


    <div class="col-lg-4" x-data="{ show: true, hide(){ this.show=false} }" :key="{{ Str::uuid() }}">
        <template x-if="show">


        <div class="card shadow-lg mb-4 border-0">
          <div class="card-header border-bottom-0 pt-7 pb-5">
            <div class="d-flex justify-content-center">
                <template x-if="plan_option">
                    <h1 class="fw-bold"   x-text="plan.price.per_year ? plan.price.per_year: '$0' "> </h1>

                </template>
                <template x-if="!plan_option">
                    <h1 class="fw-bold" x-text="plan.price.per_month ? plan.price.per_month: '$0' "> </h1>
                </template>

                <span class="d-flex align-items-center">
                    <template x-if="!plan_option"><span >/month</span></template>
                    <template x-if="plan_option"><span>/year</span></template>
                </span>




            </div>
            <h5 class="fw-bold text-center" x-text="plan.name"></h5>
            <span class="text-700 text-center d-block" x-text="plan.description"></span>

          </div>
          <div class="card-body mx-auto">

            <ul class="list-unstyled mb-4">
                <template x-for="feature in plan.features">
                    <li class="text-700 py-2 text-secondary"><b x-text="feature.value"></b>  <span x-text="feature.code"></span></li>
                </template>

            </ul>



            <span>
                <br>
                <div class="row">

                    <div class="col-md-12 border-1 box-1 one-time-purchase" x-bind:id="plan.id">
                      <h4>Click Here For A One-time Purchase Offer For Just $38</h4>
                    </div>
                </div>
                <br><br>
               </span>



            <div class="row">
                <button type="button" x-bind:id="plan.id" class="btn btn-lg btn-primary rounded-pill mb-3 monthly_yearly">
                    <span x-text="plan.trial_period_days > 0 ? ' Start ' + plan.trial_period_days + ' days trial ' : 'Subscribe' " x-bind:id="plan.id"></span>
                </button>
            </div>

          </div>
        </div>
        </template>
      </div>

  </template>










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


    $(document).on('click','.monthly_yearly',function(e){
        $('#selected_plan_type').val('monthly_yearly');
        $('#plan_id').val($(this).attr('id'));
        $("#form").submit();
    });

    $(document).on('click','.one-time-purchase',function(e){
        $('#selected_plan_type').val('one-time-purchase');
        $('#plan_id').val($(this).attr('id'));
        $("#form").submit();
    })



 </script>
 @endpush
