 
@extends('teckiproadmin::layouts.app')
@inject('permission', 'Teckipro\Admin\Http\Controllers\Permissions\PermissionController')

@section('title', __('Add Permission'))

@section('content')
<x-teckiproadmin::backend.card>


   <x-slot name="header">
    {{ __('Add New Permission')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.permission.index') }}">{{ __('Back') }}</a>
   </x-slot>

   <x-slot name="body">

    <form action="{{ route('admin.permission.create') }}" method="post">

             @csrf
             @if ($errors->any())
                 <div class="alert alert-danger" role="alert">
                     Please fix the following errors
                 </div>
             @endif


             <div class="row">
                
              <div class="col-md-3 col-xs-12">
                <x-teckiproadmin::backend.form-group-select selectedValue="{{ old('type') ?? '' }}" name="type" id="type" label="Type *" :options="$types"></x-teckiproadmin::backend.form-group-select>

            </div>

                <div class="col-md-6 col-xs-12">
                    <x-teckiproadmin::backend.form-group-text value="{{ old('guard_name') }}" name="guard_name" label="Guard Name" placeholder="{{ __('i.e web, api ..e.t.c') }}"></x-teckiproadmin::backend.form-group-text>
                </div>

                <div class="col-md-3 col-xs-12">
                  <x-teckiproadmin::backend.form-group-text value="{{ old('name') }}" name="name" label="Route or custom name" placeholder="{{ __('Enter route or custom name') }}"></x-teckiproadmin::backend.form-group-text>
                </div>


            </div>


            <div class="row">
                
               
  
                  <div class="col-md-6 col-xs-12">
                      <x-teckiproadmin::backend.form-group-text value="{{ old('description') }}" name="description" label="Description" placeholder="{{ __('Route description i.e delete post') }}"></x-teckiproadmin::backend.form-group-text>
                  </div>
  
                  <div class="col-md-3 col-xs-12">
                    <x-teckiproadmin::backend.form-group-text value="{{ old('parent_id') }}" name="parent_id" label="Parent Id" placeholder="{{ __('Parent ID') }}"></x-teckiproadmin::backend.form-group-text>
                  </div>
  
  
              </div>
  


    



   </x-slot>

   <x-slot name="footer">
    <button name="submit" type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save</button>
   </x-slot>
</form>
</x-teckiproadmin::backend.card>




@endsection


