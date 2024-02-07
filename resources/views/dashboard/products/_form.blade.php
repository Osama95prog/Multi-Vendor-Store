<div class="form-group">
    {{-- <label for="">product Name</label> --}}
    {{-- <input type="text" name="name"
        @class([
        "form-control",
        "is-invalid" => $errors->has('name')
    ]) id=""

    value="{{  old('name',$product->name)}}">
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror --}}
    <x-form.input label="Product Name"  type="text" class="form-control-lg" name="name"  :value="$product->name" />
</div>
<div class="form-group">
    <label for="">Store </label>
    <x-form.select :options="App\Models\store::all()" name="store_id" placeholder="store" :selected=" $product->store_id"/>
</div>
<div class="form-group">
    <label for="">Category </label>
    <x-form.select :options="App\Models\category::all()" name="category_id" placeholder="category" :selected=" $product->category_id"/>

    {{-- <select name="product_id"  class="form-control" id="">
        <option value=""> Primary product</option>
        @foreach ($Categories as $product )
            <option value="{{ $product->id }}" @selected( old('product_id', $product->product_id ) == $product->id )> {{ $product->name }}</option>
        @endforeach
    </select> --}}
</div>
<div class="form-group">
    <x-form.textarea label="Description"  class="form-control-lg" name="description"  :value="$product->description" />
</div>
<div class="form-group">
    <x-form.label id="image">Image</x-form.label   >
    @if($product->image)
        <div class="m-3">
            <img src="{{asset('storage/' .$product->image) }}" alt="" height="150">
        </div>
    @endif
    <x-form.input  type="file" name="image" />

</div>
<div class="form-group">
    <x-form.input label="Price" name="price" :value="$product->price" />
</div>
<div class="form-group">
    <x-form.input label="Compare Price" name="compare_price" :value="$product->compare_price" />
</div>
<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags" />
</div>
<div class="form-group">
    <label for="">Status</label>
    <div>
        <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
    </div>
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">{{ $button_label ?? 'save' }}</button>
</div>

@push('styles')
<link href="{{ asset('css/tagify.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('js/tagify.js') }}"></script>
<script src="{{ asset('js/tagify.polyfills.min.js') }}"></script>

<script>
    var inputElm = document.querySelector('[name=tags]'),
    tagify = new Tagify (inputElm);
</script>
@endpush
