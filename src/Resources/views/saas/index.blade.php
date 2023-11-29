
@extends('teckiproadmin::layouts.app')

@section('title', __('Saas Subscriptions'))

@section('content')

<x-teckiproadmin::backend.card>
    <x-slot name="header">
     {{ __('List Of Saas Subscriptions')  }}
    </x-slot>


    <x-slot name="body">

        @livewire('saas-subscription-table')

    </x-slot>
 </x-teckiproadmin::backend.card>


@endsection
