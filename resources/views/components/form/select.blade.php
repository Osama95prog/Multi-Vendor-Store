@props([
     'name','options' , 'selected' => false, 'placeholder' => 'select an option'
])
<select name = {{ $name }}
    {{ $attributes->class([
            "form-control",
            "is-invalid" => $errors->has($name)
    ]) }}>
    <option value=""> {{ $placeholder }}</option>
    @foreach ($options as $value)
        <option
            value="{{ $value['id'] }}"
            @selected( @old($name,$selected) == $value['id'])
        >
            {{ $value['name'] }}
        </option>
    @endforeach
</select>
    @error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
