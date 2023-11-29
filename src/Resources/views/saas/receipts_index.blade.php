
@extends('teckiproadmin::layouts.app')

@section('title', __('Saas Subscriptions'))

@section('content')

<x-teckiproadmin::backend.card>
    <x-slot name="header">
     {{ __('List Of Receipts [Paddle]')  }}
    </x-slot>


    <x-slot name="body">

        @livewire('receipt-subscription-table')

    </x-slot>
 </x-teckiproadmin::backend.card>


@endsection
