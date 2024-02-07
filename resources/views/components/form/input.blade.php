@props([
    'type' => 'text', 'name', 'value' => '','label' => false
])
@if($label)
    <label for="{{ $name }}">{{ $label }}</label>
@endif
<input
    type="{{ $type }}"
    name="{{ $name }}"
    {{-- @class([
        "form-control",
        "is-invalid" => $errors->has($name)
    ]) --}}
    {{ $attributes->class([
         "form-control",
        "is-invalid" => $errors->has($name)
    ]) }}
    value="{{  old($name,$value)}}"
    id="{{ $name }}"
    >

@error($name)
<div class="invalid-feedback">
    {{ $message }}
</div>
@enderror
