
@extends('teckiproadmin::layouts.app')

@section('title', __('Launch Subscription Management'))

@section('content')


<x-teckiproadmin::backend.card>
    <x-slot name="header">
     {{ __('List Of Launch Subscriptions')  }}
    </x-slot>


    <x-slot name="body">

     @livewire('launch-subscription-table')

    </x-slot>
 </x-teckiproadmin::backend.card>


@endsection
