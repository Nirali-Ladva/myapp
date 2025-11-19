@extends('layouts.app')

@section('content')
<h2>Children List</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('children.create') }}" class="btn btn-primary mb-3">Add Child</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($children as $child)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $child->first_name }}</td>
                <td>{{ $child->last_name }}</td>
                <td>{{ $child->email }}</td>
                <td>{{ $child->country }}</td>
                <td>{{ $child->age }}</td>
                <td>
                    <a href="{{ route('children.edit', $child->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('children.destroy', $child->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No children found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $children->links() }} <!-- Pagination -->
@endsection
