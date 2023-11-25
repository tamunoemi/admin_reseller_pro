@props(['id'=>'','label'=>'','name'=>'','class'=>'','options'=>[],'selectedValue'=>'','optionsreverseorder'=>false,'invalidclass'=>''])


    @error('{{ $name }}')
    @php
        $invalidclass = "is-invalid";
    @endphp
    @enderror


<div class="form-group">

    @if ($label)
    <label @if ($id) for="{{ $id ?? '' }}"  @endif >{{ $label }}</label>
    @endif

    <select name="{{ $name }}" @if ($id) id="{{ $id ?? '' }}" @endif  {{ $attributes->merge(['class'=>'form-control '.$class.' '.$invalidclass])  }} data-allow-clear="1" >
        @if ($options)

            @foreach ($options as $key=>$value)

                @if ($selectedValue==$value)

                @if ($optionsreverseorder)
                <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                <option value="{{ $value }}" selected>{{ $key }}</option>
                @endif

                @else

                @if ($optionsreverseorder)
                <option value="{{ $key }}">{{ $value }}</option>
                @else
                <option value="{{ $value }}">{{ $key }}</option>
                @endif


                @endif


            @endforeach
        @endif

    </select>


    {{ $slot }}

    @error('{{ $name }}')
      <span class=" is-invalid"> {{ $message }}</span>
    @enderror

  </div>
