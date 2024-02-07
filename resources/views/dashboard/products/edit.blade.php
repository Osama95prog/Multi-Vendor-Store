@extends('layouts.dashboard')

@section('title','Edit Product')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active">  Product</li>
    <li class="breadcrumb-item active">Edit Product</li>
@endsection

@section('content')

<form action="{{ route('dashboard.products.update',['product'=>$product->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch ')
    @include('dashboard.products._form',[
        'button_label' => 'update'
    ])

</form>
@endsection
