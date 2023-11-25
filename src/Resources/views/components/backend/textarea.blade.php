@props(['label'=>'','id'=>'','name'=>'', 'class'=>''])

<div class="form-group">

    @if ($label)
    <label @if ($id) for="{{ $id ?? '' }}"  @endif >{{ $label }}</label>
    @endif

    <textarea  name="{{ $name }}" @if ($id) id="{{ $id ?? '' }}" @endif  {{ $attributes->merge(['class'=>'form-control '.$class])  }} >{{ $slot }}</textarea>

    @error('{{ $name }}')
      <span class="invalid"> {{ $message }}</span>
    @enderror

  </div>
