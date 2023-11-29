
@extends('teckiproadmin::layouts.app')

@section('title', __('Announcement Management'))

@section('content')
<x-teckiproadmin::backend.card>
   <x-slot name="header">
    {{ __('Announcement Reports')  }}
   </x-slot>

   <x-slot name="headerActions">
    <a href="{{ route('admin.announcement.create') }}">{{ __('Create New') }}</a>
   </x-slot>

   <x-slot name="body">

      <livewire:announcement-table />

   </x-slot>
</x-teckiproadmin::backend.card>




@endsection
