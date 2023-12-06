{{--
    Provide pay button options such as monthly, yearly or any other.
--}}

@props(['details'=>''])
@if($details)
 {{ dd($details) }}
@endif
<x-teckiproadmin::backend.button>Purchase Plan</x-teckiproadmin::backend.button>
