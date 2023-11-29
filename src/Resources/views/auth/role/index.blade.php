@extends('teckiproadmin::layouts.app')

@section('title', __('Role Management'))

@section('content')
    <x-teckiproadmin::backend.card>
        <x-slot name="header">
            @lang('Role Management')
        </x-slot>

        <x-slot name="headerActions">
            <x-teckiproadmin::utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.auth.role.create')"
                :text="__('Create Role')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:roles-table />
        </x-slot>
    </x-teckiproadmin::backend.card>
@endsection
