@if(isset($errors) && $errors->any())
    <x-teckiproadmin::utils.alert type="danger" class="header-message">
        @foreach($errors->all() as $error)
            {{ $error }}<br/>
        @endforeach
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('flash_success'))
    <x-teckiproadmin::utils.alert type="success" class="header-message">
        {{ session()->get('flash_success') }}
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('flash_warning'))
    <x-teckiproadmin::utils.alert type="warning" class="header-message">
        {{ session()->get('flash_warning') }}
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('flash_info') || session()->get('flash_message'))
    <x-teckiproadmin::utils.alert type="info" class="header-message">
        {{ session()->get('flash_info') }}
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('flash_danger'))
    <x-teckiproadmin::utils.alert type="danger" class="header-message">
        {{ session()->get('flash_danger') }}
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('status'))
    <x-teckiproadmin::utils.alert type="success" class="header-message">
        {{ session()->get('status') }}
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('resent'))
    <x-teckiproadmin::utils.alert type="success" class="header-message">
        @lang('A fresh verification link has been sent to your email address.')
    </x-teckiproadmin::utils.alert>
@endif

@if(session()->get('verified'))
    <x-teckiproadmin::utils.alert type="success" class="header-message">
        @lang('Thank you for verifying your e-mail address.')
    </x-teckiproadmin::utils.alert>
@endif
