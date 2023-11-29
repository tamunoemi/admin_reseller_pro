 
@extends('teckiproadmin::layouts.app')
@inject('tutorial', 'Teckipro\Admin\Http\Controllers\TutorialController')

@section('title', __('Create Tutorial'))

@section('content')
<x-teckiproadmin::backend.card>


   <x-slot name="header">
    {{ __('Add New Tutorial')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.tutorial.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">

    <form action="{{ route('admin.tutorial.create') }}" method="post">

             @csrf
             @if ($errors->any())
                 <div class="alert alert-danger" role="alert">
                     Please fix the following errors
                 </div>
             @endif


             <div class="row">
                
              <div class="col-md-3 col-xs-12">
                <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('type') ?? $tutorial::TYPE_YOUTUBE }}" name="type" id="type" label="Type *" :options="$tutorialOptions"></x-teckiproadmin::backend.form-group-select>

            </div>

                <div class="col-md-6 col-xs-12">
                    <x-teckiproadmin::backend.form-group-text value="{{ old('title') }}" name="title" label="Title" placeholder="{{ __('Enter tutorial title') }}"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-3 col-xs-12">
                  <x-teckiproadmin::backend.form-group-text value="{{ old('video_url') }}" name="video_url" label="Video Id/URL" placeholder="{{ __('Enter video id or url depending on type') }}"></x-teckiproadmin::backend.form-group-text>
                </div>


            </div>


        




            <div class="row">
                <div class="col-12 col-md-6">

                  <div class="form-group">
                    <label for="visible" ><i class="fas fa-hand-holding-usd"></i>Visible?</label>

                      <div class="form-group">

                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="visible"  class="custom-switch-input" {{ old('visible')=='1' ? 'checked' : '' }}>
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


