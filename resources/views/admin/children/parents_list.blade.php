@extends('layouts.app')

@section('content')
<h3>Parents List</h3>

@if($parents->isEmpty())
    <p>No parents found.</p>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Select</th>
        </tr>
    </thead>
    <tbody>
        @foreach($parents as $index => $parent)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $parent->first_name }}</td>
            <td>{{ $parent->last_name }}</td>
            <td>{{ $parent->email }}</td>
            <td>
                <input type="checkbox" name="parents[]" value="{{ $parent->id }}"
                    {{ in_array($parent->id, $selectedParents ?? []) ? 'checked' : '' }}>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
