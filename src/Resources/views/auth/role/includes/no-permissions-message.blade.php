@if ($general->count() + $categories->count() === 0)
    <x-teckiproadmin::utils.alert type="warning" class="mb-0" :dismissable="false">
        <i class="fa fa-info-circle"></i> @lang('There are no permissions to choose from.')
    </x-teckiproadmin::utils.alert>
@endif
