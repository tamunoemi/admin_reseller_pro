<footer class="c-footer">
    <div>
        <strong>
            @lang('Copyright') &copy; {{ date('Y') }}
            <x-teckiproadmin::utils.link href="http://laravel-boilerplate.com" target="_blank" :text="__(appName())" />
        </strong>

        @lang('All Rights Reserved')
    </div>

    <div class="mfs-auto">
        @lang('Powered by')
        <x-teckiproadmin::utils.link href="http://laravel-boilerplate.com" target="_blank" :text="__(appName())" /> &
        <x-teckiproadmin::utils.link href="https://coreui.io" target="_blank" text="CoreUI" />
    </div>
</footer>
