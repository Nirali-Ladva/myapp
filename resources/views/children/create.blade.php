@extends('layouts.app')

@section('content')
<h2>Add Child</h2>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('children.store') }}" method="POST" enctype="multipart/form-data">
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

    <div class="row mt-3">
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Country</label>
            <input type="text" name="country" value="{{ old('country') }}" class="form-control">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label>Birth Date</label>
            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>State</label>
            <input type="text" name="state" value="{{ old('state') }}" class="form-control">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label>City</label>
            <input type="text" name="city" value="{{ old('city') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Birth Certificate</label>
            <input type="file" name="birth_certificate" class="form-control">
        </div>
    </div>

    @if(isset($parents))
        <div class="mt-3">
            <label>Select Parents:</label>
            @foreach($parents as $parent)
                <div>
                    <input type="checkbox" name="parents[]" value="{{ $parent->id }}">
                    {{ $parent->first_name }} {{ $parent->last_name }}
                </div>
            @endforeach
        </div>
    @endif

    <button type="submit" class="btn btn-success mt-3">Add Child</button>
</form>
@endsection
