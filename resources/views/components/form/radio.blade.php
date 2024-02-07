@props([
     'name', 'value' => '','options' , 'checked' => false,'label' => false
])
@if($label)
<label for="{{ $name }}">{{ $label }}</label>
@endif
@foreach ($options as $value => $text)

    <div class="form-check">
        <input
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked( @old($name,$checked) == $value)
        {{ $attributes->class([
            "form-check-input",
            "is-invalid" => $errors->has($name)
            ]) }}
        >
        <label class="form-check-label">{{ $text }}</label>
    </div>

    @endforeach
    @error($name)
    {{-- this div to put sibling with is-invalid class as this is a condition to show the error inside the invalid-feedback div --}}
    <div class="is-invalid"></div>
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror


