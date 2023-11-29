@extends('teckiproadmin::layouts.app')

@section('title', __('Deleted Users'))

@section('breadcrumb-links')
    @include('teckiproadmin::auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-teckiproadmin::backend.card>
        <x-slot name="header">
            @lang('Deleted Users')
        </x-slot>

        <x-slot name="body">
            <livewire:users-table status="deleted" />
        </x-slot>
    </x-teckiproadmin::backend.card>
@endsection
