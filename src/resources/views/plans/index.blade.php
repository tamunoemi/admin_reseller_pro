
@extends('teckiproadmin::layouts.app')

@section('title', __('Plans Management'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('List Of Plans')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.plan.create') }}">{{ __('Create Plan') }}</a>
   </x-slot>

   <x-slot name="body">

    @livewire('plan-table')

   </x-slot>
</x-teckiproadmin::backend.card>




@endsection
