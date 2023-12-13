{{-- https://codepen.io/pepperface/pen/GppQvX --}}
@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection

@push('before-styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<style>

.btn{
  border: 1px solid #ebebed !important;
  padding: 0.26rem 0.7rem !important;
}
.well-sm {
    padding: 9px;
    border-radius: 3px;
}
.well {
    min-height: 10px;
    padding: 9px;
    margin-bottom: 10px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
}

.btninactive {
    background-color: #222;
    border-color: #fff;
    border: 1px solid;
}

  .dlk-radio input[type="radio"],
.dlk-radio input[type="checkbox"] 
{
	margin-left:-99999px;
	display:none;
}
.dlk-radio input[type="radio"] + .fa ,
.dlk-radio input[type="checkbox"] + .fa {
     opacity:0.15
}
.dlk-radio input[type="radio"]:checked + .fa,
.dlk-radio input[type="checkbox"]:checked + .fa{
    opacity:1
}
.plan-option-btn{
  color: #ccc !important;
}

.white{
  color: #ffffff !important;
}
</style>
@endpush


@section('content')
      <!-- ============================================-->
      <!-- <section> begin ============================-->



        <form id="form" action="{{ route('paddle.revieworder') }}" method="get">
            @csrf

            <input type="hidden" name="plan_id" id="plan_id" value="">
            <input type="hidden" name="selected_plan_type" id="selected_plan_type" value="">

        <section class="py-8" id="pricing">

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
                    
                    <div class="well well-sm text-center">
                    
                      <div class="dlk-radio btn-group">

                        @if($monthlyplanstate=='1')
                        <label class="btn btninactive plan-option-btn" data-index="monthly">
                          <input name="choices[1]" class="form-control" type="radio" value="1" defaultchecked="checked">
                          <i class="bi bi-check-circle-fill"></i> Monthly
                        </label>
                        @endif
                  
                        @if($yearlyplanstate=='1')
                        <label class="btn btninactive plan-option-btn" data-index="yearly">
                            <input name="choices[1]" class="form-control" type="radio" value="2" defaultchecked="checked">
                            <i class="bi bi-check-circle-fill"></i> Yearly
                          </label>
                        @endif

                      @if($onetimeplanstate=='1')
                     <label class="btn btninactive plan-option-btn" data-index="one-time">
                         <input name="choices[1]" class="form-control" type="radio" value="3" defaultchecked="checked">
                         <i class="bi bi-check-circle-fill"></i> One time
                     </label>
                     @endif

                    </div>
                  </div>
                   
                  </div>
                </div>



              
    
    @isset($yearlyplans)

   
      @foreach ($yearlyplans as $plan)

      
        <div class="col-lg-4 yrly" >
    
    
            <div class="card shadow-lg mb-4 border-0">
              <div class="card-header border-bottom-0 pt-7 pb-5">
                <div class="d-flex justify-content-center">
         
                    <h1 class="fw-bold">${{ $plan['price']['per_year'] }} </h1>
                
                    <span class="d-flex align-items-center">
                      <span >/year</span>
                    </span>
    
    
                </div>
                <h5 class="fw-bold text-center">{{ $plan['name'] }}</h5>
                <span class="text-700 text-center d-block">{{ $plan['description'] }}</span>
    
              </div>
              <div class="card-body mx-auto">
    
                <ul class="list-unstyled mb-4">
                  @if(!empty($plan['features']))

                    @foreach($plan['features'] as $feature)
                    <li class="text-700 py-2 text-secondary">
                      <b>{{ $feature['value'] }}</b>  <span>{{ $feature['code'] }}</span>
                    </li>
                    @endforeach

                  @endif
    
                </ul>
    
    
                <div class="row">
                    <button type="button"  class="btn btn-lg btn-primary rounded-pill mb-3 submit" id="{{ $plan['id'] }}">
                        <span>Subscribe</span>
                    </button>
                </div>
    
              </div>
            </div>
         
          </div>
                 
        
      @endforeach
    
    @endisset
    
 



    @isset($onetimeplans)

   
      @foreach ($onetimeplans as $plan)

      
        <div class="col-lg-4 onetime" >
    
    
            <div class="card shadow-lg mb-4 border-0">
              <div class="card-header border-bottom-0 pt-7 pb-5">
                <div class="d-flex justify-content-center">
         
                    <h1 class="fw-bold">${{ $plan['price']['one_time_purchase'] }} </h1>
                
                    <span class="d-flex align-items-center">
                      <span >/one time</span>
                    </span>
    
    
                </div>
                <h5 class="fw-bold text-center">{{ $plan['name'] }}</h5>
                <span class="text-700 text-center d-block">{{ $plan['description'] }}</span>
    
              </div>
              <div class="card-body mx-auto">
    
                <ul class="list-unstyled mb-4">
                  @if(!empty($plan['features']))

                    @foreach($plan['features'] as $feature)
                    <li class="text-700 py-2 text-secondary">
                      <b>{{ $feature['value'] }}</b>  <span>{{ $feature['code'] }}</span>
                    </li>
                    @endforeach

                  @endif
    
                </ul>
    
    
                <div class="row">
                    <button type="button"  class="btn btn-lg btn-primary rounded-pill mb-3 submit" id="{{ $plan['id'] }}">
                        <span>Subscribe</span>
                    </button>
                </div>
    
              </div>
            </div>
         
          </div>
                 
        
      @endforeach
    
    @endisset






    @isset($monthlyplans)

   
      @foreach ($monthlyplans as $plan)

      
        <div class="col-lg-4 mthly" >
    
    
            <div class="card shadow-lg mb-4 border-0">
              <div class="card-header border-bottom-0 pt-7 pb-5">
                <div class="d-flex justify-content-center">
         
                    <h1 class="fw-bold">${{ $plan['price']['per_month'] }} </h1>
                
                    <span class="d-flex align-items-center">
                      <span >/month</span>
                    </span>
    
    
                </div>
                <h5 class="fw-bold text-center">{{ $plan['name'] }}</h5>
                <span class="text-700 text-center d-block">{{ $plan['description'] }}</span>
    
              </div>
              <div class="card-body mx-auto">
    
                <ul class="list-unstyled mb-4">
                  @if(!empty($plan['features']))

                    @foreach($plan['features'] as $feature)
                    <li class="text-700 py-2 text-secondary">
                      <b>{{ $feature['value'] }}</b>  <span>{{ $feature['code'] }}</span>
                    </li>
                    @endforeach

                  @endif
    
                </ul>
    
    
                <div class="row">
                    <button type="button"  class="btn btn-lg btn-primary rounded-pill mb-3 submit" id="{{ $plan['id'] }}">
                        <span>Subscribe</span>
                    </button>
                </div>
    
              </div>
            </div>
         
          </div>
                 
        
      @endforeach
    
    @endisset



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


    $(document).on('click','.submit',function(e){
        
        $('#plan_id').val($(this).attr('id'));
        $("#form").submit();
    });


    $('.mthly').hide();
    $('.yrly').hide();
    $('.onetime').hide();


    $(document).on('click','.plan-option-btn',function(e){
        e.preventDefault();
        $('.btn').removeClass('btn-primary').removeClass('white');
        $(this).removeClass('btninactive').addClass('btn-primary').addClass('white');
        let id = $(this).attr('data-index');
        $('#selected_plan_type').val(id);
        if(id=='monthly'){ 

          $('.yrly').hide();
          $('.onetime').hide();
          $('.mthly').show();

        }else if(id=='yearly'){

          $('.mthly').hide();
          $('.onetime').hide();
          $('.yrly').show();

        }else if(id=='one-time'){

          $('.mthly').hide();
          $('.yrly').hide();
          $('.onetime').show();
          
        }
        
        
    })


  let dp = "{{ $defaultplan }}";
  if(dp=='m'){
    let el = document.querySelector(`[data-index="monthly" ]`);
    $(el).click();
  }
  if(dp=='y'){
    let el = document.querySelector(`[data-index="yearly" ]`);
    $(el).click();
  }
  if(dp=='o'){
    let el = document.querySelector(`[data-index="one-time" ]`);
    $(el).click();
  }

 </script>
 @endpush
