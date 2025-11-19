@extends('layouts.app')

@section('content')
<h3>Edit Parent</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('parents.update', $parent->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6">
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name', $parent->first_name) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name', $parent->last_name) }}" class="form-control">
        </div>
    </div>

    <div class="mt-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $parent->email) }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Country</label>
        <input type="text" name="country" value="{{ old('country', $parent->country) }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control">
        @if($parent->profile_image)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$parent->profile_image) }}" width="100">
            </div>
        @endif
    </div>

    <div class="mt-3">
        <label>Residential Proofs (multiple)</label>
        <input type="file" name="residential_proofs[]" multiple class="form-control">
        @if(!empty($parent->residential_proofs))
            <div class="row mt-2">
                @foreach($parent->residential_proofs as $file)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ asset('storage/'.$file) }}" target="_blank">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-3">
        <label>Link Children</label>
        @foreach($children as $child)
            <div>
                <input type="checkbox" name="children[]" value="{{ $child->id }}"
                    @if($parent->children->contains($child->id)) checked @endif
                >
                {{ $child->first_name }} {{ $child->last_name }}
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        <button class="btn btn-primary">Update Parent</button>
    </div>
</form>

<h3 class="mt-4">Linked Children</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Country</th>
            <th>Age</th>
        </tr>
    </thead>
    <tbody>
        @forelse($related as $child)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $child->first_name }}</td>
            <td>{{ $child->last_name }}</td>
            <td>{{ $child->email }}</td>
            <td>{{ $child->country }}</td>
            <td>{{ $child->age }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">No children linked to this parent.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
