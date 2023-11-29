
@extends('teckiproadmin::layouts.app')

@section('title', __('Permission Management'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('List Of Permissions')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.permission.create') }}">{{ __('Add New') }}</a>
   </x-slot>

   <x-slot name="body">

      <livewire:permission-table />

   </x-slot>
</x-teckiproadmin::backend.card>




@endsection
