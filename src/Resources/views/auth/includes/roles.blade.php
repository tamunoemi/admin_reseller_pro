<div class="form-group row">
    <label for="roles" class="col-md-2 col-form-label">@lang('Roles')</label>

    <div class="col-md-10">
        <div x-show="userType === '{{ $model::TYPE_ADMIN }}'">
            @include('teckiproadmin::auth.includes.partials.role-type', ['type' => $model::TYPE_ADMIN])
        </div>

        <div x-show="userType === '{{ $model::TYPE_USER }}'">
            @include('teckiproadmin::auth.includes.partials.role-type', ['type' => $model::TYPE_USER])
        </div>
    </div>
</div><!--form-group-->
