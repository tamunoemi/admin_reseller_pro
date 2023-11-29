@extends('teckiproadmin::layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('teckiproadmin::auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <x-teckiproadmin::backend.card>
        <x-slot name="header">
            @lang('User Management')
        </x-slot>

        @if ($logged_in_user->hasAllAccess())
            <x-slot name="headerActions">
                <x-teckiproadmin::utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.auth.user.create')"
                    :text="__('Create User')"
                />
            </x-slot>
        @endif

        <x-slot name="body">

                <livewire:users-table />

        </x-slot>
    </x-teckiproadmin::backend.card>
@endsection
