@props(['type'=>'submit', 'class'=>'','buttonType'=>'primary','icon'=>'', 'name'=>'','size'=>'btn-sm'])

@switch($buttonType)
    @case('primary')
        @php
            $buttonType = "btn-primary";
        @endphp
        @break

    @case('success')
        @php
            $buttonType = "btn-success";
        @endphp
        @break

    @case('danger')
        @php
            $buttonType = "btn-danger";
        @endphp
        @break

    @case('warning')
        @php
            $buttonType = "btn-warning";
        @endphp
        @break

    @case('info')
        @php
            $buttonType = "btn-info";
        @endphp
        @break

    @default

@endswitch
<button name="{{ $name }}" type="{{ $type }}" {{ $attributes->merge(['class'=>'btn  '.$class.' '.$buttonType.' '.$size]) }}  {{ $attributes }}>
    @if ($icon)
    <i class="{{ $icon }}"></i>
    @else
    <i class="fas fa-save"></i>
    @endif

    {{ $slot }} </button>
