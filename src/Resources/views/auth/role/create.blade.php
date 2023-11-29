@inject('model', '\Teckipro\Admin\Models\User')

@extends('teckiproadmin::layouts.app')

@section('title', __('Create Role'))

@section('content')
    <x-teckiproadmin::forms.post :action="route('admin.auth.role.store')">
        <x-teckiproadmin::backend.card>
            <x-slot name="header">
                @lang('Create Role')
            </x-slot>

            <x-slot name="headerActions">
                <x-teckiproadmin::utils.link class="card-header-action" :href="route('admin.auth.role.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div x-data="{userType : '{{ $model::TYPE_USER }}'}">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">@lang('Type')</label>

                        <div class="col-md-10">
                            <select name="type" class="form-control" required x-on:change="userType = $event.target.value">
                                <option value="{{ $model::TYPE_USER }}">@lang('User')</option>
                                <option value="{{ $model::TYPE_ADMIN }}">@lang('Administrator')</option>
                            </select>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                        <div class="col-md-10">
                            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />
                        </div>
                    </div>

                    @include('teckiproadmin::auth.includes.permissions')
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Role')</button>
            </x-slot>
        </x-teckiproadmin::backend.card>
    </x-teckiproadmin::forms.post>
@endsection
