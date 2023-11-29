
@extends('teckiproadmin::layouts.app')

@section('title', __('Module Management'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('List Of Modules')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.module.create') }}">{{ __('Create Module') }}</a>
   </x-slot>

   <x-slot name="body">

    @livewire('modules-table')

   </x-slot>
</x-teckiproadmin::backend.card>




@endsection
