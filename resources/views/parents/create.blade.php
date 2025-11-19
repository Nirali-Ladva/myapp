@extends('layouts.app')

@section('content')
<h2>Add Parent</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('parents.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <label>First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
        </div>
    </div>

    <div class="mt-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Country</label>
        <input type="text" name="country" value="{{ old('country') }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Birth Date</label>
        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
    </div>

    <div class="mt-3 row">
        <div class="col-md-6">
            <label>State</label>
            <input type="text" name="state" value="{{ old('state') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>City</label>
            <input type="text" name="city" value="{{ old('city') }}" class="form-control">
        </div>
    </div>

    <div class="mt-3">
        <label>Education</label>
        <input type="text" name="education" value="{{ old('education') }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Occupation</label>
        <input type="text" name="occupation" value="{{ old('occupation') }}" class="form-control">
    </div>

    <div class="mt-3">
        <label>Residential Proofs (Multiple)</label>
        <input type="file" name="residential_proofs[]" multiple class="form-control">
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('parents.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection
