@extends('layouts.dashboard')

@section('title','Categories')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item active"> Categories</li>
@endsection

@section('content')
{{-- @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif --}}

<x-myalert type="success" />
<x-myalert type="info" />

<form action="{{ URL::current() }}" method="get">
    <div class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <x-form.select class="mx-2"
            :options="[
                ['id' => 'active','name' => 'Active'],
                ['id' => 'archived', 'name' => 'Archived'],
                ['id' => 'all','name' => 'All']
            ]"
            name="status" :selected="request('status')" />
        <button class="btn btn-dark mx-2"> filter</button>
    </div>

</form>
<a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-info mb-4"> Create </a>
<a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-info mb-4"> Trash </a>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Name</th>
            <th>Parent</th>
            <th>products *</th>
            <th>status</th>
            <th>Created At</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $category)
            <tr>
                <td><img src="{{asset('storage/' .$category->image) }}" alt="" height="50"></td>
                <td>{{ $category->id }}</td>
                <td><a href="{{ route('dashboard.categories.show',$category->id) }}">{{ $category->name }} </a> </td>
                <td>{{ $category->parent->name }}</td>
                <td>{{ $category->products_count }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <a href="{{ route('dashboard.categories.edit',['category'=>$category->id]) }}" class="btn btn-sm btn-outline-success">edit</a>
                </td>
                <td>
                    <form action="{{ route('dashboard.categories.destroy',['category'=>$category->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                    </form>
                </td>
            </tr>
        @empty
        <td colspan="9">nothig to view</td>
        @endforelse
    </tbody>
</table>
{{ $categories->withQueryString()->appends(['search' => 2])->links() }}
@endsection
