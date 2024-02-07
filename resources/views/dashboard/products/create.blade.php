@extends('layouts.dashboard')

@section('title','Create Product')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">Create Product</li>
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

<form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('dashboard.products._form')
</form>
@endsection
