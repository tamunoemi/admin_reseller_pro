
@extends('teckiproadmin::layouts.app')
@inject('package', 'Teckipro\Admin\Http\Controllers\PlanController')

@section('title', __('Edit Module'))

@section('content')
<x-teckiproadmin::backend.card>


   <x-slot name="header">
    {{ __('Edit Module')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.module.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">

    <form action="{{ route('admin.module.edit',$data) }}" method="post">

             @csrf
             @if ($errors->any())
                 <div class="alert alert-danger" role="alert">
                     Please fix the following errors
                 </div>
             @endif


             <div class="row">
                <div class="col-md-4 col-xs-12">

                    <x-teckiproadmin::backend.form-group-text value="{{ old('module_name') ?? $data->module_name }}" name="module_name"  label="Module Name *"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-4 col-xs-12">
                    <x-teckiproadmin::backend.form-group-text value="{{ old('route') ?? $data->route }}" name="route" label="Route" placeholder="{{ __('Enter route path') }}"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-4 col-xs-12">
                  <x-teckiproadmin::backend.form-group-text value="{{ old('add_ons_id') ?? $data->add_ons_id }}" name="add_ons_id" label="Add-on ID" placeholder="{{ __('Enter Add-on ID') }}"></x-teckiproadmin::backend.form-group-text>
                </div>


            </div>


            <div class="row">
              <div class="col-md-12">
                <x-teckiproadmin::backend.textarea name="extra_text" label="Extra Text" >{{ old('extra_text') ?? $data->extra_text }} </x-teckiproadmin::backend.textarea>
              </div>
            </div>






            <div class="row">
                <div class="col-12 col-md-6">

                  <div class="form-group">
                    <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Limit Enabled </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="limit_enabled"  class="custom-switch-input" {{ old('limit_enabled')=='1' || $data->extra_text=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>



                        </label>
                      </div>
                  </div>
                </div>

                <div class="col-12 col-md-6">
                  <div class="form-group" id="highlight_container">
                    <label for="highlight" ><i class="far fa-lightbulb"></i>Bulk Limit Enabled </label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="bulk_limit_enabled" class="custom-switch-input" {{ old('bulk_limit_enabled')=='1' || $data->bulk_limit_enabled=='1' ? 'checked' : '' }}>
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">Yes</span>

                        </label>
                      </div>
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

$("#all_modules").on('change',function(){
  if ($(this).is(':checked'))
  $(".modules:not(.mandatory)").prop("checked",true);
  else
  $(".modules:not(.mandatory)").prop("checked",false);
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
        if(val==='{{ $package::TYPE_LAUNCH }}'){
            $('.paddleIdContainer').hide();
            $('.launchContainer').show();
        }else if(val==='{{ $package::TYPE_SAAS }}'){
            $('.launchContainer').hide();
            $('.paddleIdContainer').show();
        }

     })
</script>
@endpush



