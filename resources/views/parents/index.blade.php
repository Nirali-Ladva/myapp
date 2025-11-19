@extends('layouts.app')

@section('content')
<h2>Parents List</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('parents.create') }}" class="btn btn-primary mb-3">Add Parent</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($parents as $parent)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $parent->first_name }}</td>
                <td>{{ $parent->last_name }}</td>
                <td>{{ $parent->email }}</td>
                <td>
                    <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No parents found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
