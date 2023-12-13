{{--
    Provide pay button options such as monthly, yearly or any other.
--}}

@props(['details'=>'','payLink'=>'', 'pid'=>''])

@php
  $paddle_id = $pid;
@endphp


@empty($paddle_id)
<x-teckiproadmin::backend.alert type="error" message="This product is not available for sale"></x-teckiproadmin::backend.alert>
@endempty

@if(!empty($paddle_id))
<x-paddle-button :url="$payLink" class="px-8 py-4">
    Subscribe
</x-paddle-button>
{{--
    <x-teckiproadmin::backend.button id="paddle-pay-button">Purchase Plan</x-teckiproadmin::backend.button>
--}}

@endif




