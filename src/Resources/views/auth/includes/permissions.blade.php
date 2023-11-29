<div class="form-group row">
    <label for="permissions" class="col-md-2 col-form-label">@lang('Additional Permissions')</label>

    <div class="col-md-10">
        @include('teckiproadmin::auth.role.includes.no-permissions-message')

        <div x-show="userType === '{{ $model::TYPE_ADMIN }}'">
            @include('teckiproadmin::auth.includes.partials.permission-type', ['type' => $model::TYPE_ADMIN])
        </div>

        <div x-show="userType === '{{ $model::TYPE_USER}}'">
            @include('teckiproadmin::auth.includes.partials.permission-type', ['type' => $model::TYPE_USER])
        </div>
    </div>
</div><!--form-group-->
