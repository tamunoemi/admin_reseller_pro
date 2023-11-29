 
@extends('teckiproadmin::layouts.app')
@inject('Announcement', 'Teckipro\Admin\Http\Controllers\AnnouncementController')

@section('title', __('Create Announcement'))

@section('content')
<x-teckiproadmin::backend.card>


   <x-slot name="header">
    {{ __('Add New Announcement')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.announcement.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">

    <form action="{{ route('admin.announcement.create') }}" method="post">

             @csrf
             @if ($errors->any())
                 <div class="alert alert-danger" role="alert">
                     Please fix the following errors
                 </div>
             @endif


             <div class="row">
                
              <div class="col-md-3 col-xs-12">
                <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('type') ?? $Announcement::TYPE_FRONTEND }}" name="type" id="type" label="Type *" :options="$types"></x-teckiproadmin::backend.form-group-select>

            </div>

            <div class="col-md-3 col-xs-12">
                <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('area')  }}" name="area" label="Area *" :options="$area"></x-teckiproadmin::backend.form-group-select>

            </div>

                <div class="col-md-3 col-xs-12">
                    <x-teckiproadmin::backend.form-group-text class="datepicker" value="{{ old('starts_at') }}" name="starts_at" label="Starts At" ></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-3 col-xs-12">
                
                  <x-teckiproadmin::backend.form-group-text class="datepicker" value="{{ old('ends_at') }}" name="ends_at" label="Ends At"></x-teckiproadmin::backend.form-group-text>
                </div>


            </div>


            <div class="row">
             <div class="col-md-12">
                <label>Message</label>
                <textarea name="message" id="" class="form-control" rows="10"></textarea>
             </div>
            </div>


        




            <div class="row">
                <div class="col-12 col-md-6">

                  <div class="form-group">
                    <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Enabled?</label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="enabled"  class="custom-switch-input" {{ old('enabled')=='1' ? 'checked' : '' }}>
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
<!-- datetimepicker -->
<link href="{{ mix('css/jquery.datetimepicker.css') }}" rel="stylesheet">

<!-- select2 -->
<link href="{{ mix('css/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ mix('css/select2/select2-bootstrap4.css') }}" rel="stylesheet">
@endpush


@push('after-scripts')

<!-- datetimepicker -->
<script src="{{ mix('js/php-date-formatter.min.js') }}"></script>
<script src="{{ mix('js/jquery.mousewheel.js') }}"></script>
<script src="{{ mix('js/jquery.datetimepicker.js') }}"></script>


<script>
$('.datepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
startDate:	new Date(),
format:'Y-m-d h:i:s',
formatDate:'Y-m-d h:i:s',
});

</script>

<!-- select2 -->
<script src="{{ mix('js/select2/select2.min.js') }}"></script>
<script src="{{ mix('js/select2/select2_custom.js') }}"></script>

@endpush
