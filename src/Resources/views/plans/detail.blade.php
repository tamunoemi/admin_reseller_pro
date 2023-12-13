
@extends('teckiproadmin::layouts.app')

@section('title', __('Edit Plan'))
@inject('class', 'Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController')
@section('content')
<x-teckiproadmin::backend.card>

   <x-slot name="header">
    {{ __(' Plan Detail: '.$plan->name)  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.plan.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">


    <div class="row">
        <div class="col-md-4 col-xs-12">

            <x-teckiproadmin::backend.form-group-text value="{{ $plan->name }}" name="name" id="name" label="plan Name *" readonly></x-teckiproadmin::backend.form-group-text>
        </div>

        <div class="col-md-4 col-xs-12">
            <x-teckiproadmin::backend.form-group-text value="{!! $plan->price !!}" name="price" id="price" label="Price - {{ env('PAYMENT_CURRENCY') }} *" placeholder="{{ __('Price') }}" readonly></x-teckiproadmin::backend.form-group-text>
        </div>


        <div class="col-md-4 col-xs-12">
            <x-teckiproadmin::backend.form-group-select readonly="true" disabled="true" selectedValue="{{ $plan->type }}" name="type" id="type" label="Type *" :options="$planOptions" readonly></x-teckiproadmin::backend.form-group-select>

        </div>


    </div>




            <br>
            <br>
            <h6>Usage Limits</h6>
            <br>

            <div class="row">
                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text value="{{ $plan->monthly_limit }}" name="monthly_limit" id="monthly_limit" label="Monthly Usage Limit" placeholder="{{ __('monthly limit') }}"></x-teckiproadmin::backend.form-group-text>

                 </div>


                  <div class="col-3">

                    <x-teckiproadmin::backend.form-group-text value="{{ $plan->bulk_limit }}" name="bulk_limit" id="bulk_limit" label="Total Bulk Usage Limit" placeholder="{{ __('bulk limit') }}"></x-teckiproadmin::backend.form-group-text>

                  </div>
            </div>
            <br>

            @if ($plan->type==$class::TYPE_SAAS)
            <div class="row">
                @php
                $paddle_id = !empty($plan->paddle_id) ? $plan->paddle_id : $class->default_gateway_id_json;
                $stripe_id = !empty($plan->stripe_id ) ? $plan->stripe_id : $class->default_gateway_id_json;
              @endphp
                @if(config('my_config.default_gateway')=='paddle')
                <div class="col-4">
                    <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="paddle_id" id="paddle_id" label="Paddle ID">{!! $paddle_id !!}</x-teckiproadmin::backend.textarea>
                </div>
                @endif

                @if(config('my_config.default_gateway')=='stripe')
                <div class="col-4">
                    <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="stripe_id" id="stripe_id" label="Stripe ID">{!! $stripe_id !!}</x-teckiproadmin::backend.textarea>
                </div>
                @endif

            </div>
            @endif


            @if ($plan->type==$class::TYPE_LAUNCH)

                <div class="row">
                    <div class="col-12">
                        <h6>Ensure at least one of these is set</h6>
                    </div>
                </div>

                @php
                $jvzoo_id = !empty($plan->jvzoo_id ) ? $plan->jvzoo_id : $class->default_gateway_id_json;
                $warriorplus_id = !empty($plan->warriorplus_id ) ? $plan->warriorplus_id : $class->default_gateway_id_json;
                $appsumo_id = !empty($plan->appsumo_id ) ? $plan->appsumo_id : $class->default_gateway_id_json;
                $clickbank_id = !empty($plan->clickbank_id ) ? $plan->clickbank_id : $class->default_gateway_id_json;
                @endphp

                <div class="row">
                    <div class="col-3">
                        <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="jvzoo_id" id="jvzoo_id" label="JVZOO ID">{!! $jvzoo_id !!}</x-teckiproadmin::backend.textarea>
                    </div>

                    <div class="col-3">
                        <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="warriorplus_id" id="warriorplus_id" label="WPLUS ID">{!! $warriorplus_id !!}</x-teckiproadmin::backend.textarea>
                    </div>

                    <div class="col-3">
                        <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="appsumo_id" id="appsumo_id" label="APPSUMO ID">{!! $appsumo_id !!}</x-teckiproadmin::backend.textarea>
                    </div>

                    <div class="col-3">
                        <x-teckiproadmin::backend.textarea readonly="true" disabled="true" name="clickbank_id" id="clickbank_id" label="CLICKBANK ID">{!! $clickbank_id !!}</x-teckiproadmin::backend.textarea>
                    </div>
                </div>

            @endif

            <br>

            <div class="row">

                @php
                 $coupon = !empty($plan->coupon) ? $plan->coupon : $plan->default_coupon_json;
                 $discount = !empty($plan->discount) ? $plan->discount : $plan->default_discount_json;
                @endphp

                <div class="col-4">
                    <x-teckiproadmin::backend.textarea name="description" label="Plan Description">{{ $plan->description }}</x-teckiproadmin::backend.textarea>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text readonly="true" disabled="true" value="{!! $coupon !!}" name="coupon" id="coupon" label="Coupon"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text readonly="true" disabled="true" value="{!! $discount !!}" name="discount" id="discount" label="Discount"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-2">
                    <x-teckiproadmin::backend.form-group-text readonly="true" disabled="true" type="number" value="{{ $plan->trial_period_days }}" name="trial_period_days" id="trial_period_days" label="Trial Period Days"></x-teckiproadmin::backend.form-group-text>
                </div>

            </div>


            <br>






            <div class="row">
                <div class="col-12 col-md-6">

                  <div class="form-group">
                    <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Available to Purchase </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="visible"  class="custom-switch-input" {{ $plan->visible=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>



                        </label>
                      </div>
                  </div>
                </div>

                <div class="col-12 col-md-6">
                  <div class="form-group" id="highlight_container">
                    <label for="highlight" ><i class="far fa-lightbulb"></i>Highlighted Plan </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="highlight" class="custom-switch-input" {{ $plan->highlight=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>

                        </label>
                      </div>
                  </div>
                </div>
              </div>



              <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="">Roles *</label>
                         @php $mandatory_roles = array(0); @endphp
                        <div class="table-responsive">
                           <table class="table table-bordered">
                            @php
                             $current_roles=array();
                             $current_roles=explode(',',$plan->role_ids);


                             echo "<tr>";
                                 echo "<th class='info' width='20px'>";
                                   echo "#";
                                 echo "</th>";
                                 echo "<th class='text-center info' width='20px'>";
                                   echo '<input class="regular-checkbox" id="all_roles" type="checkbox"/><label for="all_roles"></label>';
                                 echo "</th>";
                                 echo "<th class='info'>";
                                   echo "Role";
                                 echo "</th>";

                              echo "</tr>";

                             $SL=0;
                             foreach($roles as $role)
                             {
                              $SL++;
                              echo "<tr>";
                                 echo "<td class='text-center'>".$SL."</td>";
                                 echo "<td class='text-center'>";
                                 $check_module = '';
                                 if(is_array($current_roles) && in_array($role['id'], $current_roles)) $check_module='checked';  @endphp
                                   <input  name="module_ids[]" id="box@php echo $SL;@endphp" class="modules regular-checkbox @php if(in_array($role['id'], $mandatory_roles)) echo 'mandatory';@endphp" @php echo $check_module; @endphp @php if(in_array($role['id'], $mandatory_roles)) echo 'checked onclick="return false;"';@endphp type="checkbox" value="@php echo $role['id']; @endphp"/> @php

                                   $cssstyle="cursor_pointer";
                                   if(in_array($role['id'], $mandatory_roles)) $cssstyle = "border_color_6777EF cursor_pointer' title='".__('This is a mandatory module and can not be unchecked.')."' data-toggle='tooltip'";

                                    echo "<label for='box".$SL."' class='".$cssstyle."'></label>";
                                 echo "</td>";

                                 echo "<td>".$role['name']."</td>";

                               echo "</tr>";
                             }
                             @endphp
                           </table>
                        </div>
                        @error('module_ids')
                        <span class="invalid-feedback red">{{ $message }}</span>
                        @enderror
                      </div>

              </div>
              </div>






   </x-slot>



</x-teckiproadmin::backend.card>




@endsection



