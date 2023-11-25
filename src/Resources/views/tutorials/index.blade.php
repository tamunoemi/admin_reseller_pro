
@extends('teckiproadmin::layouts.app')

@section('title', __('Module Management'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('List Of Tutorials')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.tutorial.create') }}">{{ __('Create Tutorial') }}</a>
   </x-slot>

   <x-slot name="body">

      <livewire:tutorial-table />

   </x-slot>
</x-teckiproadmin::backend.card>




@endsection
