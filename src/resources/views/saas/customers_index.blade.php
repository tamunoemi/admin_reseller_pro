
@extends('teckiproadmin::layouts.app')

@section('title', __('Saas Subscriptions'))

@section('content')

<x-teckiproadmin::backend.card>
    <x-slot name="header">
     {{ __('List Of Subscribed Customers')  }}
    </x-slot>


    <x-slot name="body">

        @livewire('saas-customers-table')

    </x-slot>
 </x-teckiproadmin::backend.card>


@endsection
