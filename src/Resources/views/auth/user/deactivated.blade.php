@extends('teckiproadmin::layouts.app')

@section('title', __('Deactivated Users'))

@section('breadcrumb-links')
    @include('teckiproadmin::auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-teckiproadmin::backend.card>
        <x-slot name="header">
            @lang('Deactivated Users')
        </x-slot>

        <x-slot name="body">
            <livewire:users-table status="deactivated" />
        </x-slot>
    </x-teckiproadmin::backend.card>
@endsection
