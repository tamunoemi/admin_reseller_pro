@extends('teckiproadmin::checkout.layouts.app')

@section('title', __('Plans'))

@section('nav')
 @include('teckiproadmin::checkout.layouts.pricing-nav')
@endsection
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

@push('after-styles')
<style>


fieldset label {
	font-weight: 300;
	font-size: 12px;
	cursor: pointer;
	display: flex;
	align-items: center;
	flex: 1;
	box-sizing: border-box;
	display: flex;
    padding: 10px 10px 0px 50px;
	font-weight: 500;
	color: #191919;
	-webkit-tap-highlight-color: transparent;
}

fieldset input[type="radio"] {
	position: relative;
	appearance: none;
	-webkit-appearance: none;
	transition: linear 0.8s;
	height: 0;
	width: 0;
	-webkit-tap-highlight-color: transparent;
}

fieldset input[type="radio"]:after {
	content: "";
	position: absolute;
	height: 16px;
	width: 16px;
	top: -10.5px;
	left: -30px;
	border-radius: 20px;
	border: 2px solid #3a88f6;
	transition: linear 0.2s;
	cursor: pointer;
}

fieldset input[type="radio"]:checked:after {
	content: "";
	position: absolute;
	height: 16px;
	width: 16px;
	background: #3a88f6;
	transition: linear 0.2s;
	cursor: pointer;
}

fieldset input[type="radio"]:checked:before {
	content: "";
	position: absolute;
	height: 8px;
	width: 8px;
	border-radius: 4px;
	background: #fff;
	left: -24px;
	top: -4.5px;
	z-index: 1;
	cursor: pointer;
}

.radio-item-container {
	display: flex;
	flex-direction: column;
    border: 1px solid #cdccd1;
	border-top: 0;
	background: #fff;
	border-radius: 0 0 10px 10px;
	padding: 10px 0;
}

.radio-item {
	display: flex;
	position: relative;
}

.icon {
	font-size: 24px;
	position: absolute;
	right: 26px;
	top: 11px;
	transition: linear 0.3s;
}

fieldset input[type="radio"]:checked + span > .icon {
	transform: scale(1.7);
}

.card-details{
    margin-left:25px;
    color: burlywood;
}

.pt{
    font-size: x-small;
    display: inline;
    margin-left: 1px;
    color: darkgoldenrod;
    position: absolute;
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

        <!------ Include the above in your HEAD tag ---------->
        @include('teckiproadmin::flash-message')
        <div class='container'>
            <div class='row' style='padding-top:25px; padding-bottom:25px;'>
                <div class='col-md-12'>
                    <div id='mainContentWrapper'>
                        <div class="col-md-8 col-md-offset-2">
                            <h2 style="text-align: center;">
                                Review Your Order & Complete Checkout
                            </h2>
                         
                            <div class="shopping_cart">

                                <form class="form-horizontal" role="form" action="{{ route('stripe.subscription.create') }}" method="post" id="payment-form">
                                    @csrf

                                    <input type="hidden" name="plan" value="{{ $stripeId }}">
                                    <input type="hidden" name="plan_name" value="{{ $details['name'] }}">
                                    <input type="hidden" name="type" value="{{ $selectedPlanType }}">
                                    <input type="hidden" name="price" value="{{ $realPrice }}">

                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a  href="#collapseOne">Review
                                                        Your Order</a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse">
                                                <div class="panel-body">
                                                    <div class="items">
                                                        <div class="col-md-9">
                                                            <table class="table table-striped">
                                                                <tr>
                                                                    <td colspan="2">
                                                                       
                                                                        <b>{{ $details['name'] }}</b></td>
                                                                </tr>

                                                                
                                                                @if(!empty($details['features']))
                                                                @foreach ($details['features'] as $feature)
                                                                    <tr>
                                                                        <td>
                                                                            <ul>
                                                                               
                                                                                <li>{{ $feature['code'] }}</li>
                                                                               
                                                                             
                                                                            </ul>
                                                                        </td>
                                                                        <td>
                                                                            <b>{{ $feature['value'] }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    
                                                                @endif
                                                            </table>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div style="text-align: center;">
                                                                <h3>Order Total</h3>
                                                                <h3><span style="color:green;">${{ $realPrice }}.00</span> <span class="pt">{{ $selectedPlanType }}</span></h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                  
                       
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a  href="#">
                                                    <b>Payment Information</b>
                                                </a>
                                            </h4>
                                        </div>
                                        <div  class="panel-collapse ">
                                            <div class="panel-body">
                                              
                                                @auth
                                                    
                                               

                                                @if($paymentMethodType=='oneoff')

                                                <x-teckiproadmin::plans.stripe.single-charge-payment-method-setup :intent="$intent" />
                
                                                @else
                
                                                <x-teckiproadmin::plans.stripe.recurring-payment-method-setup :paymentMethods="$paymentMethods" :intent="$intent" />
                                                @endif

                                                @endauth

                                                @guest
                                                <p>You will need to create an account with us to proceed with this checkout</p>
                                                <a href="{{ route('google.redirect') }}" class="btn btn-primary"> Login with Google </a>
                                                @endguest


                                                <br/>
                                                <div style="text-align: left;"><br/>
                                                    By submiting this order you are agreeing to our <a href="/legal/billing/">universal
                                                        billing agreement</a>, and <a href="/legal/terms/">terms of service</a>.
                                                    If you have any questions about our products or services please contact us
                                                    before placing this order.
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
                
        
        

          </section>

          <!-- <section> close ============================-->
          <!-- ============================================-->
 @endsection



@push('after-scripts')
<script>

</script>
@endpush
