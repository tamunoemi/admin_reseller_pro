@extends('teckiproadmin::layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <x-teckiproadmin::backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
            @lang('Welcome to the Dashboard')
        </x-slot>
    </x-teckiproadmin::backend.card>
@endsection
