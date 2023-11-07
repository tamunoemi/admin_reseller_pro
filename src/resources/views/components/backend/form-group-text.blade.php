@props(['id'=>'', 'type'=>'text','name'=>'','label'=>'','value'=>'','class'=>'','invalidclass'=>''])

 @error(''.$name.'')
 @php
     $invalidclass = "is-invalid";
 @endphp
 @enderror

<div class="form-group">

    @if ($label)
    <label @if ($id ?? '') for="{{ $id ?? '' ?? '' }}"  @endif >{{ $label }}</label>
    @endif

    <input type="{{ $type }}" value="{{ $value }}" name="{{ $name }}" @if ($id ?? '') id="{{ $id ?? '' ?? '' }}" @endif  {{ $attributes->merge(['class'=>'form-control '.$class.' '.$invalidclass])  }}   >
    {{ $slot }}


    @error(''.$name.'')
      <span class="is-invalid "> {{ $message }}</span>
    @enderror

  </div>
