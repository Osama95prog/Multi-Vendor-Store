<div class="form-group">
    {{-- <label for="">Category Name</label> --}}
    {{-- <input type="text" name="name"
        @class([
        "form-control",
        "is-invalid" => $errors->has('name')
    ]) id=""

    value="{{  old('name',$category->name)}}">
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror --}}
    <x-form.input label="Category Name"  type="text" class="form-control-lg" name="name"  :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Category Parent</label>
    <x-form.select :options="$parents" name="parent_id" placeholder="Primary Category" :selected=" $category->parent_id"/>

    {{-- <select name="parent_id"  class="form-control" id="">
        <option value=""> Primary Category</option>
        @foreach ($parents as $parent )
            <option value="{{ $parent->id }}" @selected( old('parent_id', $category->parent_id ) == $parent->id )> {{ $parent->name }}</option>
        @endforeach
    </select> --}}
</div>
<div class="form-group">
    {{-- <label for="">Description</label>
    <textarea name="description" class="form-control"> {{@old('description', $category->description)  }}</textarea> --}}
    <x-form.textarea label="Description"  class="form-control-lg" name="description"  :value="$category->description" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label   >
    @if($category->image)
        <div class="m-3">
            <img src="{{asset('storage/' .$category->image) }}" alt="" height="150">
        </div>
    @endif
    {{-- <input type="file" name="image" class="form-control"> --}}
    <x-form.input  type="file" name="image" />

</div>
<div class="form-group">
    <label for="">status</label>
    <x-form.radio  name="status"  :options="['active' => 'Active','archived' => 'Archived']" :checked="$category->status"/>
    {{-- <div class="form-check">
        <input class="form-check-input" type="radio" name="status" value="archived" @checked( @old('status',$category->status) == 'archived')>
        <label class="form-check-label">archive</label>
    </div> --}}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ $button_label ?? 'save' }}</button>
</div>
