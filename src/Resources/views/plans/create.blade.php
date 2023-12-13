
@extends('teckiproadmin::layouts.app')
@inject('plan', 'Teckipro\Admin\Domains\Plans\Http\Controllers\PlanController')

@section('title', __('Plans'))

@section('content')
<x-teckiproadmin::backend.card>


   <x-slot name="header">
    {{ __('Create Plan')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.plan.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">

    <x-teckiproadmin::utils.alert type="warning" dismissable="0">
      NOTE: For payments to be recorded/reflected, the following must hold true:
      <ol>
      <li>The plan name must not have spacing and cannot be changed aftewards so must choose wisely.</li>
      <li>The name of the plan must be same as what was created on {{ config('my_config.default_gateway') }}</li>
    
      
      </ol> 
    </x-teckiproadmin::utils.alert>

    <form action="{{ route('admin.plan.create') }}" method="post">

             @csrf
             @if ($errors->any())
                 <div class="alert alert-danger" role="alert">
                     Please fix the following errors <br><br>
                     <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                 </div>
             @endif
 

             <div class="row">
                <div class="col-md-3 col-xs-6">

                    <x-teckiproadmin::backend.form-group-text value="{{ old('name') }}" name="name" id="name" label="Plan Name *"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-3 col-xs-6">

                  <x-teckiproadmin::backend.form-group-text value="{{ old('name_alias') }}" name="name_alias" id="name_alias" label="Plan Name Alias *"></x-teckiproadmin::backend.form-group-text>
              </div>

                <div class="col-md-2 col-xs-6">
                    <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('type') ?? $plan::TYPE_LAUNCH }}" name="type" id="type" label="Type *" :options="$planOptions"></x-teckiproadmin::backend.form-group-select>
                </div>

                <div class="col-md-4 col-xs-6">
                    @php
                      $price = !empty(old('price')) ? old('price'): $plan->default_price_json;
                    @endphp
                     <x-teckiproadmin::backend.textarea name="price" id="price" label="Price - {{ env('PAYMENT_CURRENCY') }} *" placeholder="{{ __('Price') }}">{!! $price !!}</x-teckiproadmin::backend.textarea>

                </div>




            </div>

            <div class="row paddleIdContainer">
                @php
                $paddle_id = !empty(old('paddle_id')) ? old('paddle_id'): $plan->default_gateway_id_json;
                $stripe_id = !empty(old('stripe_id')) ? old('stripe_id'): $plan->default_gateway_id_json;
              @endphp
                
                @if(config('my_config.default_gateway')=='paddle')
                <div class="col-4">
                    <x-teckiproadmin::backend.textarea name="paddle_id" id="paddle_id" label="Paddle ID">{!! $paddle_id !!}</x-teckiproadmin::backend.textarea>
                </div>
                @endif

                @if(config('my_config.default_gateway')=='stripe')
                <div class="col-4">
                    <x-teckiproadmin::backend.textarea name="stripe_id" id="stripe_id" label="Stripe ID">{!! $stripe_id !!}</x-teckiproadmin::backend.textarea>
                </div>
                @endif
            </div>


            <div class="launchContainer">

                @php
                $jvzoo_id = !empty(old('jvzoo_id')) ? old('jvzoo_id'): $plan->default_gateway_id_json;
                $warriorplus_id = !empty(old('warriorplus_id')) ? old('warriorplus_id'): $plan->default_gateway_id_json;
                $appsumo_id = !empty(old('appsumo_id')) ? old('appsumo_id'): $plan->default_gateway_id_json;
                $clickbank_id = !empty(old('clickbank_id')) ? old('clickbank_id'): $plan->default_gateway_id_json;
                @endphp

                <div class="row">
                    <div class="col-12">
                        <h6>Ensure at least one of these is set</h6>
                    </div>
                </div>
                <div class="row">
                <div class="col-3">
                    <x-teckiproadmin::backend.textarea name="jvzoo_id" id="jvzoo_id" label="JVZOO ID">{!! $jvzoo_id !!}</x-teckiproadmin::backend.textarea>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.textarea name="warriorplus_id" id="warriorplus_id" label="WPLUS ID">{!! $warriorplus_id !!}</x-teckiproadmin::backend.textarea>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.textarea name="appsumo_id" id="appsumo_id" label="APPSUMO ID">{!! $appsumo_id !!}</x-teckiproadmin::backend.textarea>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.textarea name="clickbank_id" id="clickbank_id" label="CLICKBANK ID">{!! $clickbank_id !!}</x-teckiproadmin::backend.textarea>
                </div>
                </div>
            </div>


            <br>


            <div class="row">

                @php
                 $coupon = !empty(old('coupon')) ? old('coupon') : $plan->default_coupon_json;
                 $discount = !empty(old('discount')) ? old('discount') : $plan->default_discount_json;
                @endphp

                <div class="col-4">
                    <x-teckiproadmin::backend.textarea name="description" label="Plan Description">{{ old('description') }}</x-teckiproadmin::backend.textarea>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text value="{!! $coupon !!}" name="coupon" id="coupon" label="Coupon"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text value="{!! $discount !!}" name="discount" id="discount" label="Discount"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-2">
                    <x-teckiproadmin::backend.form-group-text type="number" value="{{ old('trial_period_days') }}" name="trial_period_days" id="trial_period_days" label="Trial Period Days"></x-teckiproadmin::backend.form-group-text>
                </div>

            </div>


            <br>
            <h6>Subscription Duration</h6>
            <br>

            <div class="row">
                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text type="number" value="{{ old('interval_count') }}" name="interval_count" id="interval_count" label="Interval Count" placeholder="{{ __('No. of x interval') }}"></x-teckiproadmin::backend.form-group-text>

                 </div>


                  <div class="col-3">

                    <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('interval') }}" name="interval" label="Interval" :options="$validities" optionsreverseorder="true"></x-teckiproadmin::backend.form-group-select>

                  </div>
            </div>

            <br>
            <br>
            <h6>Usage Limits</h6>
            <br>

            <div class="row">
                <div class="col-3">
                    <x-teckiproadmin::backend.form-group-text value="{{ old('monthly_limit') }}" name="monthly_limit" id="monthly_limit" label="Monthly Usage Limit" placeholder="{{ __('monthly limit') }}"></x-teckiproadmin::backend.form-group-text>

                 </div>


                  <div class="col-3">

                    <x-teckiproadmin::backend.form-group-text value="{{ old('bulk_limit') }}" name="bulk_limit" id="bulk_limit" label="Total Bulk Usage Limit" placeholder="{{ __('bulk limit') }}"></x-teckiproadmin::backend.form-group-text>

                  </div>
            </div>
            <br>



            <div class="row">
                <div class="col-12 col-md-4">

                  <div class="form-group">
                    <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Available to Purchase </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="visible"  class="custom-switch-input" {{ old('visible')=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>



                        </label>
                      </div>
                  </div>
                </div>

                <div class="col-12 col-md-4">
                  <div class="form-group" id="highlight_container">
                    <label for="highlight" ><i class="far fa-lightbulb"></i>Highlighted plan </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="highlight" class="custom-switch-input" {{ old('highlight')=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>

                        </label>
                      </div>
                  </div>
                </div>


                <div class="col-12 col-md-4">
                  <div class="form-group" id="highlight_container">
                    <label for="highlight" ><i class="far fa-lightbulb"></i>Users can resell? </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="user_can_resell" class="custom-switch-input" {{ old('user_can_resell')=='1' ? 'checked' : '' }}>
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

                         echo "<tr>";
                             echo "<th class='info' width='20px'>";
                              echo "#";
                             echo "</th>";
                             echo "<th class='text-center info' width='20px'>";
                               echo '<input class="regular-checkbox" id="all_roles" type="checkbox"/><label for="all_roles"></label>';
                             echo "</th>";

                             echo "<th class='info'>";
                               echo "Role Name";
                             echo "</th>";

                             echo "<th class='text-center info' colspan='2'>";
                               echo "Role Type";
                             echo "</th>";

                          echo "</tr>";


$SL=0;
                         foreach($roles as $role)
                         {
                          $SL++;
                          echo "<tr>";
                             echo "<td class='text-center'>".$SL."</td>";
                             echo "<td class='text-center'>";@endphp
                                <input  name="role_ids[]" id="box@php echo $SL;@endphp" class="roles regular-checkbox @php if(in_array($role['id'], $mandatory_roles)) echo 'mandatory';@endphp" @php if(in_array($role['id'], $mandatory_roles)) echo 'checked onclick="return false;"';@endphp  type="checkbox" value="@php echo $role['id']; @endphp"/> @php

                                 $cssstyle="cursor_pointer";
                                 if(in_array($role['id'], $mandatory_roles)) $cssstyle = "border_color_6777EF cursor_pointer' title='This is a mandatory module and can not be unchecked.' data-toggle='tooltip'";

                                echo "<label for='box".$SL."' class='".$cssstyle."'></label>";
                             echo "</td>";

                             echo "<td>".$role['name']."</td>";

                             echo "<td>".$role['type']."</td>";

                           echo "</tr>";
                         }


                         @endphp
                       </table>
                    </div>
                    @error('role_ids')
                      <span class="invalid-feedback red">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
              </div>






   </x-slot>

   <x-slot name="footer">
    <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save</button>
   </x-slot>
</form>
</x-teckiproadmin::backend.card>




@endsection


@push('after-styles')

<!-- select2 -->
<link href="{{ mix('css/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ mix('css/select2/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush

@push('after-scripts')
    <script>

if($("#price_default").val()=="0") $("#hidden").hide();
else $("#validity").show();

$("#all_roles").on('change',function(){
  if ($(this).is(':checked'))
  $(".roles:not(.mandatory)").prop("checked",true);
  else
  $(".roles:not(.mandatory)").prop("checked",false);
});

$("#price_default").on('change',function(){
  if($(this).val()=="0") $("#hidden").hide();
  else $("#hidden").show();
});
    </script>

<!-- select2 -->
<script src="{{ mix('js/select2/select2.min.js') }}"></script>
 <script src="{{ mix('js/select2/select2_custom.js') }}"></script>

<script>
    $('.paddleIdContainer').hide();

     $('#type').on('change', function(e){
        let val = e.target.value;
        if(val==='{{ $plan::TYPE_LAUNCH }}'){
            $('.paddleIdContainer').hide();
            $('.launchContainer').show();
        }else if(val==='{{ $plan::TYPE_SAAS }}'){
            $('.launchContainer').hide();
            $('.paddleIdContainer').show();
        }

     })
</script>
@endpush



