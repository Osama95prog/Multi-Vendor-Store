@extends('layouts.dashboard')

@section('title','Import Product')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">Import Product</li>
@endsection

@section('content')
@if($errors->any())
    <div class="alert alert-danger w-50">
        <h2>Error occured</h2>
        <ul>
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <x-form.input label="Import Products" class="form-control-lg" name="count"  />
    </div>

    <div class="form-group">
        <button class="btn btn-primary" type="submit">start import ...</button>
    </div>
    
</form>
@endsection
